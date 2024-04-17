<?php

namespace App\Services;

use App\Models\AreaKnowledge;
use App\Models\Configuration;
use App\Models\Course;
use App\Models\Curricula;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MakePetitionService
{

    public function uploadExcel($dataExcel)
    {

        $resultado = [];
        $objeto = null;
        foreach ($dataExcel as $datos) {
            foreach ($datos as $dato) {
                if (!is_null($dato[0]) && strpos($dato[0], "N°") !== false && (!is_null($dato[1]))) {
                    if (!is_null($objeto)) {
                        $resultado[] = $objeto;
                    }
                    $objeto = [
                        "N°" => $dato[0],
                        "semestre" => $dato[1],
                        "estado" => $dato[13],
                        "cursos" => []
                    ];
                } elseif (!is_null($dato[0]) && $dato[0] !== null && !is_null($objeto)) {
                    if ((!is_null($dato[1]))) {

                        $curso = [
                            "codigo" => $dato[0],
                            "nombre" => $dato[1],
                            "num_desaprobado" => $dato[2],
                            "fecha_examen" => $this->convertExcelDate($dato[3]),
                            "horas_teoricas" => $dato[4],
                            "horas_practicas" => $dato[5],
                            "creditos" => $dato[6],
                            "nota" => $dato[7],
                            'tipo_curso' => '',
                            "notas_por_creditos" => $dato[8]
                        ];

                        $objeto["cursos"][] = $curso;
                    } else {
                        $objeto["matricula"] = $dato[0];
                    }
                } elseif (is_null($dato[0]) && !is_null($dato[9]) && $dato[9] !== null && !is_null($objeto)) {
                    $objeto["creditos_cursados°"] = $dato[9];
                    $objeto["creditos_aprobados"] = $dato[10];
                    $objeto["puntos_por_semestre"] = $dato[11];
                    $objeto["promedio_ponderado_semestral"] = $dato[12];
                    $objeto["total_creditos_cursados"] = $dato[13];
                    $objeto["total_creditos_aprobados"] = $dato[14];
                    $objeto["total_puntos_acumulados"] = $dato[15];
                    $objeto["promedio_ponderado_acumulado"] = $dato[16];
                    if (!is_null($dato[1])) {
                        $objeto["condicon"] = $dato[1];
                    } else {
                        $objeto["condicon"] = '';
                    }
                }
            }
        }

        if (!is_null($objeto)) {
            $resultado[] = $objeto;
        }



        return $resultado;
    }
    public function convertExcelDate($excelValue): string
    {
        if (is_numeric($excelValue)) {
            $baseDate = Carbon::create(1900, 1, 1);
            $carbonDate = $baseDate->addDays($excelValue - 2);

            return $carbonDate->format('Y-m-d');
        } else {
            return $excelValue;
        }
    }

    public function processDataFile($objectExcel, $curricula_id)
    {



        $areas = collect($this->getAreaForCurricula($curricula_id));


        $removeAccents = function ($string) {
            return str_replace(['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú'], ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U'], $string);
        };


        $coursesInAreas = $areas->flatMap(function ($area) use ($removeAccents) {
            return $area->courses->map(function ($course) use ($area, $removeAccents) {
                return [
                    'name' => $removeAccents(strtolower(trim($course->name))),
                    'type_course' => $course->type_course,
                    'id' => $course->id,
                    'area_name' => $area->name,
                ];
            });
        });

        $objectExcel = $objectExcel->map(function ($item) use ($removeAccents) {
            $coursesInLowerCase = array_map(function ($curso) use ($removeAccents) {
                return array_map(function ($value) use ($removeAccents) {
                    return $removeAccents(strtolower($value));
                }, $curso);
            }, $item['cursos']);

            $item['cursos'] = $coursesInLowerCase;
            return $item;
        });


        $objectExcel = $objectExcel->map(function ($item) use ($coursesInAreas) {
            $semester = $this->getSemester($item['semestre']);

            $coursesWithAreaName = array_map(function ($curso) use ($coursesInAreas, $semester) {
                $nombreCurso = $curso['nombre'];
                $semester = $semester;

                $cursoEnAreas = collect($coursesInAreas)->first(function ($cursoEnArea) use ($nombreCurso, $semester) {

                    return $cursoEnArea['name'] === $nombreCurso;
                });

                $area_name = $cursoEnAreas ? $cursoEnAreas['area_name'] : null;
                $tipo_curso = $cursoEnAreas ? $cursoEnAreas['type_course'] : null;
                $id = $cursoEnAreas ? $cursoEnAreas['id'] : null;
                $uniqueKey = Str::uuid();
                $curso['semestre'] = $semester;
                $curso['nombre_area'] = $area_name;
                $curso['tipo_curso'] = $tipo_curso;
                $curso['id'] = $id;
                $curso['unique_key_course'] = $uniqueKey;


                return $curso;
            }, $item['cursos']);

            $item['cursos'] = $coursesWithAreaName;
            return $item;
        });


        $groupedCoursesByArea = collect();

        $objectExcel->each(function ($item) use (&$groupedCoursesByArea) {
            foreach ($item['cursos'] as $curso) {
                $areaName = $curso['nombre_area'];

                if (!empty($areaName)) {
                    if (!$groupedCoursesByArea->has($areaName)) {
                        $groupedCoursesByArea->put($areaName, collect());
                    }

                    $groupedCoursesByArea[$areaName]->push($curso);
                } else {
                    $noAreaName = 'No Encontrada';
                    if (!$groupedCoursesByArea->has($noAreaName)) {
                        $groupedCoursesByArea->put($noAreaName, collect());
                    }
                    $groupedCoursesByArea[$noAreaName]->push($curso);
                }
            }
        });

        return  $groupedCoursesByArea;
    }
    public function getSemester($semesterString)
    {

        $ano = '';
        $periodoRomano = '';
        if (preg_match('/\b\d{4}\b/', $semesterString, $matches)) {
            $ano = $matches[0];

            $posicionAno = strpos($semesterString, $ano);
            $substringDespuesAno = substr($semesterString, $posicionAno + strlen($ano));

            if (preg_match('/[IVXLCDM]+/', $substringDespuesAno, $matches)) {
                $periodoRomano = $matches[0];
            }
        }

        if (!empty($ano)) {
            if (!empty($periodoRomano)) {
                $resultado = "$ano-$periodoRomano";
            } else {
                $resultado = "$ano-0";
            }
        } else {
            $resultado = "0-0";
        }
        return  $resultado;
    }
    public function justOneCourseForArea($resultDataExcel)
    {


        $backup = [];
        $courses = $resultDataExcel;
        $order = 1;
        foreach ($courses as $area => $courses) {
            $uniqueCourses = [];
            foreach ($courses as $course) {
                $courseName = $course['nombre'];
                $courseScore = $course['nota'];


                if (array_key_exists($courseName, $uniqueCourses)) {
                    if ($courseScore > $uniqueCourses[$courseName]['nota']) {
                        $uniqueCourses[$courseName] = $course;
                    }
                } else {

                    $uniqueCourses[$courseName] = $course;
                }
            }

            $backup[$area] = array_values($uniqueCourses);
        }

        foreach ($backup as $area => &$coursesList) {
            foreach ($coursesList as &$course) {
                $course['order'] = $order++;
            }
        }


        return $backup;
    }
    public function getAreaForCurricula($id)
    {
        $areas = AreaKnowledge::query()
            ->select('id', 'name', 'curricula_id')
            ->where(function ($query) use ($id) {
                $query->where('curricula_id', $id)
                    ->orWhereNull('curricula_id')
                    ->orWhere('curricula_id', '');
            })
            ->with('courses:id,name,type_course,code,area_knowledge_id')
            ->get();

        return $areas;
    }
    public function getCurricula($id)
    {
        return Curricula::findOrFail($id);
    }
    public  function sumRecord($backup, $curricula_id)
    {
        $curricula = $this->getCurricula($curricula_id);
        $totalCreditos = collect($backup)->flatMap(function ($elemento) use ($curricula) {
            return $elemento ?? [];
        })->reduce(function ($carry, $elemento) use ($curricula) {
            if ($elemento['nota'] > 10.5) {
                $carry['sumaCursos'] += $elemento['creditos'];
            }

            if ($elemento['tipo_curso'] === 'electivo' && $elemento['nota'] > 10.5) {
                $carry['sumaElectivos'] += $elemento['creditos'];
                $carry['contadorElectivos'] += $elemento['creditos'];
            } elseif ($elemento['tipo_curso'] === 'actividad_libre' && $elemento['nota'] > 10.5) {
                $carry['sumaActividadLibre'] += $elemento['creditos'];
                $carry['contadorActividadLibre'] += $elemento['creditos'];
            } elseif ($elemento['tipo_curso'] !== 'electivo' && $elemento['tipo_curso'] !== 'actividad_libre' && $elemento['nota'] > 10.5) {

                $carry['sumaOtros'] += $elemento['creditos'];
            }

            return $carry;
        }, ['sumaCursos' => 0, 'sumaElectivos' => 0, 'contadorElectivos' => 0, 'sumaActividadLibre' => 0, 'contadorActividadLibre' => 0, 'sumaOtros' => 0]);

        return $totalCreditos;
    }
    public function dragAndDropTableCorse($list, $backup, $courseIdToFind)
    {


        $coursePosition = null;
        $courseFind = null;
        $continue = false;


        foreach ($list as $item) {
            if ($item['value'] == $courseIdToFind) {
                $coursePosition = $item['order'];
                break;
            }
        }

        foreach ($backup as $category => &$courses) {

            foreach ($courses as $key => $course) {
                if ($course['unique_key_course'] == $courseIdToFind) {
                    if ($course['order'] == $coursePosition) {
                        $continue = true;
                        return $backup;
                    } else {
                        $courseFind = $course;
                        unset($courses[$key]);
                        break 2;
                    }
                }
            }
        }


        if (!$continue) {
            foreach ($backup as $category => &$courses) {
                foreach ($courses as $key => $course) {
                    if ($course['order'] == $coursePosition) {
                        $courseFind["nombre_area"] = $category;
                        $courseFind["order"] = $coursePosition;




                        array_splice($courses, $key, 0, [$courseFind]);
                        break 2;
                    }
                }
            }





            foreach ($list as $item) {
                $courseIdToUpdate = $item['value'];
                $newOrder = $item['order'];

                foreach ($backup as $category => &$courses) {
                    foreach ($courses as &$course) {
                        if ($course['unique_key_course'] == $courseIdToUpdate) {
                            $course['order'] = $newOrder;
                        }
                    }
                }
            }
            foreach ($backup as $category => &$courses) {
                usort($courses, function ($a, $b) {
                    return $a['order'] - $b['order'];
                });
            }
        } else {
            return $backup;
        }

        return $backup;
    }
    public function getCreditsArea($curricula_id, $curricula)
    {

        $totalCreditsForAreaCurrentCurricula = [];

        $areaForCredits = AreaKnowledge::where('curricula_id', $curricula_id)->where('total_credits', '>', 0)->get();

        foreach ($areaForCredits as $area) {
            $totalCreditsForAreaCurrentCurricula[] = [
                'name' => $area->name,
                'total_credits' => $area->total_credits,
            ];
        }
        $totalCreditsForAreaCurrentCurricula[] = (array)[
            'name' => 'ACTIVIDAD LIBRE',
            'total_credits' => $curricula['free_activity'],
        ];
        $totalCreditsForAreaCurrentCurricula[] = (array)[
            'name' => 'Electivos de especialidad',
            'total_credits' => $curricula['elective'],
        ];
        $totalCreditsForAreaCurrentCurricula[] = (array)[
            'name' => 'Experiencia pre profesional',
            'total_credits' => $curricula['pre_professional_practice'],
        ];
        return $totalCreditsForAreaCurrentCurricula;
    }

    public function getCreditsExcel($backup)
    {
        $resultArray = [];

        foreach ($backup as $key => $area) {
            $totalCredits = 0;
            foreach ($area as $curso) {
                if ($curso['nota'] > 10.5) {
                    $totalCredits += $curso['creditos'];
                }
            }

            $resultArray[] = [
                'name' => $key,
                'total_credits' => $totalCredits,
            ];
        }

        return $resultArray;
    }
    public function getResultComparationExcelBackup($totalCreditsForAreaExcel, $totalCreditsForAreaCurrentCurricula)
    {
        $secondArrayIndex = [];
        foreach ($totalCreditsForAreaExcel as $item) {
            $secondArrayIndex[$item['name']] = $item['total_credits'];
        };
        foreach ($totalCreditsForAreaCurrentCurricula as &$item) {
            $name = $item['name'];
            $item['total_credits_excel'] = isset($secondArrayIndex[$name]) ? $secondArrayIndex[$name] : 0;
        }

        $notFoundAreaName = "No Encontrada";
        if (isset($secondArrayIndex[$notFoundAreaName])) {

            $totalCreditsForAreaCurrentCurricula[] = [
                'name' => $notFoundAreaName,
                'total_credits' => 0,
                'total_credits_excel' => $secondArrayIndex[$notFoundAreaName],
            ];
        }
        return $totalCreditsForAreaCurrentCurricula;
    }
    // public function compareToCourseToExcelWithDatabase($backup, $curriculaId)
    // {
    //     $missingCourses = [];

    //     // Obtener todos los cursos obligatorios de la base de datos para la currícula especificada
    //     $coursesInDatabase = Course::where('curricula_id', $curriculaId)
    //         ->where('type_course', 'obligatorio')
    //         ->pluck('name')
    //         ->map(function ($name) {
    //             return strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $name));
    //         });


    //     foreach ($coursesInDatabase as $courseNameInDatabase) {


    //         $foundInBackup = false;

    //         foreach ($backup as $key => $value) {
    //             foreach ($value as $subValue) {
    //                 $nota = floatval($subValue['nota']); // Convertir $subValue['nota'] en un número decimal

    //                 if ($nota >= 10.5) {
    //                     // Normalizar el nombre del curso en el array
    //                     $courseNameInArray = strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $subValue['nombre']));

    //                     // Si el nombre del curso en la base de datos está en el backup y la nota es mayor a 10.5, marcarlo como encontrado
    //                     if ($courseNameInArray === $courseNameInDatabase) {
    //                         $foundInBackup = true;
    //                         break; // Romper todos los bucles y avanzar al siguiente curso en la base de datos
    //                     }
    //                 }
    //             }
    //         }

    //         // Si el curso de la base de datos no se encontró en el backup, agrégalo a $missingCourses
    //         if (!$foundInBackup) {
    //             $missingCourses[] = $courseNameInDatabase;
    //         }
    //     }

    //     dd($missingCourses);
    // }
    public function compareToCourseToExcelWithDatabaseToPair($backup, $curriculaId)
    {
        $missingCourses = [];

        // Obtener todos los cursos obligatorios de la base de datos para la currícula especificada con ciclos pares
        $coursesInDatabase = Course::where('curricula_id', $curriculaId)
            ->where(function ($query) {
                $query->where('type_course', 'obligatorio')
                    ->orWhere('type_course', 'practicas');
            })
            ->whereRaw('CAST(SUBSTRING_INDEX(cycle, " ", -1) AS SIGNED) % 2 = 0')
            ->get(['name', 'code', 'credits', 'cycle'])
            ->map(function ($course) {
                return [
                    'name' => strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $course->name)),
                    'code' => $course->code,
                    'credits' => $course->credits,
                    'cycle' => $course->cycle,
                ];
            });

        // dd($coursesInDatabase);
        foreach ($coursesInDatabase as $courseInDatabase) {
            $foundInBackup = false;

            foreach ($backup as $key => $value) {
                foreach ($value as $subValue) {
                    $nota = floatval($subValue['nota']); // Convertir $subValue['nota'] en un número decimal

                    if ($nota >= 10.5) {
                        // Normalizar el nombre del curso en el array
                        $courseNameInArray = strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $subValue['nombre']));

                        // Verificar si el nombre del curso en la base de datos está en el backup, la nota es mayor a 10.5 y el ciclo es par
                        if ($courseNameInArray === $courseInDatabase['name']) {
                            $foundInBackup = true;
                            break; // Romper todos los bucles y avanzar al siguiente curso en la base de datos
                        }
                    }
                }
            }

            // Si el curso de la base de datos no se encontró en el backup, agrégalo a $missingCourses
            if (!$foundInBackup) {
                $missingCourses[] = $courseInDatabase;
            }
        }

        return $missingCourses;
    }
    public function compareToCourseToExcelWithDatabaseToOdd($backup, $curriculaId)
    {
        $missingCourses = [];

        // Obtener todos los cursos obligatorios de la base de datos para la currícula especificada con ciclos pares
        $coursesInDatabase = Course::where('curricula_id', $curriculaId)
            ->where(function ($query) {
                $query->where('type_course', 'obligatorio')
                    ->orWhere('type_course', 'practicas');
            })
            ->whereRaw('CAST(SUBSTRING_INDEX(cycle, " ", -1) AS SIGNED) % 2 <> 0')
            ->get(['name', 'code', 'credits', 'cycle'])
            ->map(function ($course) {
                return [
                    'name' => strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $course->name)),
                    'code' => $course->code,
                    'credits' => $course->credits,
                    'cycle' => $course->cycle,
                ];
            });

        foreach ($coursesInDatabase as $courseInDatabase) {
            $foundInBackup = false;

            foreach ($backup as $key => $value) {
                foreach ($value as $subValue) {
                    $nota = floatval($subValue['nota']); // Convertir $subValue['nota'] en un número decimal

                    if ($nota >= 10.5) {
                        // Normalizar el nombre del curso en el array
                        $courseNameInArray = strtolower(str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $subValue['nombre']));

                        // Verificar si el nombre del curso en la base de datos está en el backup, la nota es mayor a 10.5 y el ciclo es par
                        if ($courseNameInArray === $courseInDatabase['name']) {
                            $foundInBackup = true;
                            break; // Romper todos los bucles y avanzar al siguiente curso en la base de datos
                        }
                    }
                }
            }

            // Si el curso de la base de datos no se encontró en el backup, agrégalo a $missingCourses
            if (!$foundInBackup) {
                $missingCourses[] = $courseInDatabase;
            }
        }

        return $missingCourses;
    }
    public function sumPairCourseCredits($pairCourse)
    {
        $coursePair = new Collection($pairCourse);
        return $coursePair->sum('credits');
    }
    public function sumOddCourseCredits($oddCourse)
    {
        $courseOdd = new Collection($oddCourse);
        return $courseOdd->sum('credits');
    }
    public function processRequestMeet($confirm, $userPetition, $totalCredits = 0)
    {
        // dd($userPetition->courses[0]['course']['name']);

        if ($confirm == 'no' && strtolower($userPetition->petition->name) == 'dirigido') {
            return $this->checkNotMeetingDirectedRequirements($userPetition);
        } elseif ($confirm == 'yes' && strtolower($userPetition->petition->name) == 'dirigido') {
            return $this->checkYesMeetingDirectedRequirements($userPetition);
        } elseif ($confirm == 'no' && strtolower($userPetition->petition->name) == 'paralelo') {
            return $this->checkNotMeetingParallelRequirements($userPetition);
        } elseif ($confirm == 'yes' && strtolower($userPetition->petition->name) == 'paralelo') {
            return $this->checkYesMeetingParallelRequirements($userPetition);
        } elseif ($confirm == 'no' && strtolower($userPetition->petition->name) == 'bachiller') {
            return $this->checkNotMeetingBachelorRequirements($userPetition);
        } elseif ($confirm == 'yes' && strtolower($userPetition->petition->name) == 'bachiller') {
            return $this->checkYesMeetingBachelorRequirements($userPetition);
        } elseif ($confirm == 'yes' && strtolower($userPetition->petition->name) == 'estado del alumno') {
            return $this->checkYesMeetingStudentStatusRequirements($userPetition, $totalCredits);
        }
    }

    public function checkNotMeetingDirectedRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'El recurrente, NO puede llevar el curso de "' . $request->courses[0]['course']['code'] . ' - ' . mb_strtoupper($request->courses[0]['course']['name']) . '" en la modalidad de curso ' . mb_strtoupper($request->petition->name) . '; COMPLETAR, según reglamento de estudios en su artículo 34°.'
        ];

        $article2 = $this->getArticleTwo();

        $articles = [$article1, $article2];

        return $articles;
    }
    public function checkNotMeetingParallelRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'El recurrente, NO puede llevar el curso de "' . $request->courses[0]['course']['code'] . ' - ' . mb_strtoupper($request->courses[0]['course']['name']) . '" y "' . $request->courses[1]['course']['code'] . ' - ' . mb_strtoupper($request->courses[1]['course']['name']) . '" en la modalidad de cursos ' . mb_strtoupper($request->petition->name) . 's; COMPLETAR, según reglamento de estudios en su artículo 43°.'
        ];

        $article2 = $this->getArticleTwo();

        $articles = [$article1, $article2];

        return $articles;
    }
    public function checkNotMeetingBachelorRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'El alumno(a) ' . mb_strtoupper($request->user_petition->surname) . ', ' . mb_strtoupper($request->user_petition->name) . ' (' . $request->user_petition->code . '), COMPLETAR, por lo tanto, NO ha concluido las exigencias del currículo  de estudios.
       '
        ];


        $articles = [$article1];

        return $articles;
    }
    public function checkYesMeetingDirectedRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'El recurrente, puede llevar el curso de "' . $request->courses[0]['course']['code'] . ' - ' . mb_strtoupper($request->courses[0]['course']['name']) . '" en la modalidad de curso ' . mb_strtoupper($request->petition->name) . '; Según reglamento de estudios en su artículo 34°.'
        ];

        $article2 = $this->getArticleTwo();

        $articles = [$article1, $article2];

        return $articles;
    }
    public function checkYesMeetingParallelRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'El recurrente, puede llevar el curso de "' . $request->courses[0]['course']['code'] . ' - ' . mb_strtoupper($request->courses[0]['course']['name']) . '" y "' . $request->courses[1]['course']['code'] . ' - ' . mb_strtoupper($request->courses[1]['course']['name']) . '" en la modalidad de cursos ' . mb_strtoupper($request->petition->name) . 's; según reglamento de estudios en su artículo 43°.'
        ];

        $article2 = $this->getArticleTwo();

        $articles = [$article1, $article2];

        return $articles;
    }
    public function checkYesMeetingBachelorRequirements($request)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'Ha concluido las exigencias del currículo de estudios, por lo tanto, se declara expedito al alumno(a) ' . mb_strtoupper($request->user_petition->surname) . ', ' . mb_strtoupper($request->user_petition->name) . ' (' . $request->user_petition->code . '), para continuar con los trámites correspondientes.
       '
        ];


        $articles = [$article1];

        return $articles;
    }
    public function checkYesMeetingStudentStatusRequirements($request, $totalCredits)
    {
        $article1 = [
            'name' => 'Artículo 1',
            'description' => 'el recurrente tiene un total de ' . $totalCredits . ' créditos aprobados, se expide el presente documentos para los fines que crea convenientes'
        ];


        $articles = [$article1];

        return $articles;
    }

    public function getArticleTwo()
    {
        return  [
            'name' => 'Artículo 2',
            'description' => 'La comisión deja a criterio de las autoridades competentes para su autorización del artículo 1. '
        ];
    }
    public function generarDocumentoWord($userPetition, $missingCoursesPair, $sumPairCourseCredits, $missingCoursesOdd, $sumOddCourseCredits, $backup, $articles, $total_credits, $totalCreditsForAreaCurrentCurricula)
    {
        $total_free_activity = 'no definido';
        $total_elective = 'no definido';
        $total_profesional_pre_practice = 'no definido';
        // dd($totalCreditsForAreaCurrentCurricula);
        foreach ($totalCreditsForAreaCurrentCurricula as $key => $value) {
            $actividad = "actividadlibre";
            $electivo = "electivosdeespecialidad";
            $practice = "experienciapreprofesional";
            $string2 = mb_strtolower(str_replace(' ', '', $value['name']));
            if ($actividad == $string2) {
                $total_free_activity = $value['total_credits_excel'];
            }
            if ($electivo == $string2) {
                $total_elective = $value['total_credits_excel'];
            }
            if ($practice == $string2) {

                $total_profesional_pre_practice = $value['total_credits_excel'];
            }
        }


        $configuration = Configuration::with('faculty', 'department')
            ->where('faculty_id', Auth::user()->faculty_id)
            ->where('department_id', Auth::user()->department_id)
            ->first();
            if(!isset($userPetition->agreement_number))
            {

                $configuration->increment('agreement_number');
            }

        $documento = new \PhpOffice\PhpWord\PhpWord();
        \PhpOffice\PhpWord\Settings::setDefaultPaper('Letter');
        $sectionStyle = array(

            'marginTop' => 1135,
            'marginLeft' => 1410,
            'marginRight' => 1320,
            'marginBottom' => 560,
        );
        $seccion = $documento->addSection($sectionStyle);

        $tableStyle = array(
                   
                    'cellMargin' => 0,
                    'width'       => 300,
                    'cellMarginRight' => 20,
                    'cellMarginBottom' => 100,
                    'cellMarginLeft' => 50,
                   
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                );
        $encabezado = $seccion->addHeader();

        $documento->addTableStyle('myTable1', $tableStyle,null);
        $tabla = $encabezado->addTable(array('width' => 5000, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER));

        $fila = $tabla->addRow(1223, ['exactHeight' => true]);

        $fila->addCell(400)->addImage($configuration->left_image, array('width' => 0.67 * 72, 'height' => 0.85 * 72, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START));

        $estiloTitulo1 = array('name' => 'Calibri', 'size' => 16, 'bold' => true, 'spaceBefore' => 0, 'spaceAfter' => 0);
        $estiloTitulo2 = array('name' => 'Calibri', 'size' => 12, 'spaceBefore' => 2, 'spaceAfter' => 0, 'spacing');
        $estiloTitulo3 = array('name' => 'Calibri', 'size' => 11, 'spaceBefore' => 2, 'spaceAfter' => 0, 'spacing');
        $estiloTitulo4 = array('name' => 'Calibri', 'size' => 10, 'spaceBefore' => 2, 'spaceAfter' => 0, 'spacing');

        $estiloParrafo = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceBefore' => 0, 'spaceAfter' => 0, 'spacing' => 0);
        $cellaTitulo = $fila->addCell(5000, array('valign' => 'top'));

        $cellaTitulo->addText(mb_strtoupper($configuration->university), $estiloTitulo1, $estiloParrafo);
        $cellaTitulo->addText('FACULTAD DE ' . mb_strtoupper($configuration->faculty->name), $estiloTitulo2, $estiloParrafo);
        if ($configuration->department) {

            $cellaTitulo->addText('FACULTAD DE ' . mb_strtoupper($configuration->department->name), $estiloTitulo3, $estiloParrafo);
        }

        $cellaTitulo->addText(mb_strtoupper($configuration->commission_name), $estiloTitulo4, $estiloParrafo);
        //  if (!isset($configuration->department)) {

        // $cellaTitulo->addText('');
        // } 
        // $cellaTitulo->addText('');

        $fila->addCell(400)->addImage($configuration->right_image, array('width' => 0.75 * 72, 'height' => 0.87 * 72, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
        Carbon::setLocale('es');
        $fechaActual = Carbon::now()->isoFormat('D [de] MMMM [del] YYYY');


        $seccion->addText(
            $configuration->city . ', ' . $fechaActual . '.',
            array('name' => 'Berlin Sans FB', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END, 'spaceAfter' => 0)
        );
        $seccion->addText(
            'Sr.',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            $configuration->director,
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            'Director de Escuela Profesional de ' . $configuration->faculty->name,
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            'Presente. -',
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );

        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );

        $seccion->addText(
            'VISTO:',
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );


        $textRun = $seccion->addTextRun();
        $text = $textRun->addText(
            'La solicitud presentada por el alumno de la ' . mb_strtoupper($userPetition->user_petition->faculties->abbreviation) . ': ' . mb_strtoupper($userPetition->user_petition->surname) . ', ' . $userPetition->user_petition->name . ' (' . $userPetition->user_petition->code . '), para llevar en el presente semestre ' . $configuration->semester . ': ',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $text =   $textRun->addText(
            mb_strtoupper($userPetition->petition->name),
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $text =   $textRun->addText(
            ' con relación al currículo actual.',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );



        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );

        $seccion->addText(
            'CONSIDERANDO:',
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            'El recurrente tiene aprobado ' . $total_credits . ' créditos, incluyendo ' . $total_free_activity . ' créditos de actividad libre y ' . $total_elective . ' créditos de cursos electivos',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );

        $textRun = $seccion->addListItemRun(0);
        $textRun->addText(' El recurrente');
        // dd($total_profesional_pre_practice);
        if ($total_profesional_pre_practice == 0) {
            $textRun->addText(' NO', array('bold' => true));
        }

        $textRun->addText(' hizo Practicas PRE-PROFESIONALES.');

        $textRun = $seccion->addListItemRun(0);
        $textRun->addText(' El recurrente');
        // dd($total_profesional_pre_practice);
        if ($total_credits <= 190) {
            $textRun->addText(' NO', array('bold' => true));
        }

        $textRun->addText(' es de último ciclo. ');


        $seccion->addListItem('Se adjunta el anexo de seguimiento curricular por áreas.', 0, array('listType' => \PhpOffice\PhpWord\Style\ListItem::TYPE_BULLET_FILLED));




        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        if (!empty($missingCoursesPair) || !empty($missingCoursesOdd)) {
            $seccion->addText(
                'Para la culminación de sus estudios le faltaría aprobar las siguientes asignaturas:',
                array('name' => 'Arial', 'size' => 10),
                array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
            );
            $seccion->addText(
                '',
                array('name' => 'Arial', 'size' => 10),
                array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
            );
            if (!empty($missingCoursesPair)) {
                $seccion->addText(
                    'SEMESTRE PAR',
                    array('name' => 'Arial', 'size' => 10, 'bold' => true),
                    array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
                );




                //                 // Crear la tabla HTML
                //                 $html = '
                // <table style="border-collapse: collapse; border: 0.1px solid grey;">
                //   <tr style="height: 20px; text-align: center; vertical-align: middle;">
                //     <th style="width: 300px; text-align: center; font-weight: bold; padding: 0;  ">CODIGO</th>
                //     <th style="width: 2000px; text-align: center; font-weight: bold; padding: 0; ">CURSO</th>
                //     <th style="width: 300px; text-align: center; font-weight: bold; padding: 0;  ">CREDITOS</th>
                //   </tr>';

                //                 // Recorrer el array $missingCoursesPair y agregar cada curso a la tabla
                //                 foreach ($missingCoursesPair as $curso) {
                //                     $html .= '
                //   <tr style="height: 13px; text-align: center; vertical-align: middle;">
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;font-size: 11px ">' . mb_strtoupper($curso['code']) . '</td>
                //     <td style="width: 2000px; text-align: left; border: 0.1px solid grey; padding: 0; margin: 0; font-size: 11px">' . mb_strtoupper($curso['name']) . '</td>
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0; font-size: 11px">' . $curso['credits'] . '</td>
                //   </tr>';
                //                 }

                //                 // Agregar la fila de totales
                //                 $html .= '
                //   <tr style="height: 18px; text-align: center; vertical-align: middle;">
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;font-size: 11px "></td>
                //     <td style="width: 300px; text-align: right; font-weight: bold; padding: 0;font-size: 12px">TOTAL</td>
                //     <td style="width: 300px; text-align: center; font-weight: bold; padding: 0;font-size: 12px">' . $sumPairCourseCredits . '</td>
                //   </tr>';

                //                 $html .= '</table>';

                //                 \PhpOffice\PhpWord\Shared\Html::addHtml($seccion, $html);

                $table = $seccion->addTable(['width' => 10000, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);
                $tableStyle = array(
                    'borderSize'  => 3,
                    'cellMargin' => 20,
                    'width'       => 300,
                    'cellMarginRight' => 20,
                    'cellMarginBottom' => 10,
                    'cellMarginLeft' => 50,
                    'borderColor' => '666666',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                );

                $fancyTableFirstRowStyle = ['borderBottomSize' => 6, 'borderBottomColor' => '0000FF', 'bgColor' => 'bdbebd'];
                $documento->addTableStyle('myTable2', $tableStyle, $fancyTableFirstRowStyle);
                $table = $seccion->addTable('myTable2');
                $styleTextCellHeader = array('bold' => true, 'name' => 'Arial', 'size' => 9);
                $styleTextCellBody = array('name' => 'Arial', 'size' => 8);
                $cellHCentered = array('bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
                $cellHBodyCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
                $cellVCentered = ['valign' => 'center'];
                // Add the table headers
                $table->addRow(250, ['exactHeight' => true]);
                $table->addCell(null, $cellVCentered)->addText('CODIGO', $styleTextCellHeader, $cellHCentered);

                $table->addCell(null, $cellVCentered)->addText('NOMBRE', $styleTextCellHeader, $cellHCentered);

                $table->addCell(null, $cellVCentered)->addText('CREDITOS', $styleTextCellHeader, $cellHCentered);
                // Set the row height


                // Add the table data

                foreach ($missingCoursesPair as $item => $course) {


                    $styleCellBody = array('valign' => 'center');


                    $table->addRow(250, ['exactHeight' => true]);
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['code']), $styleTextCellBody, $cellHBodyCentered);
                    $table->addCell(10000, $styleCellBody)->addText(mb_strtoupper($course['name']), $styleTextCellBody);
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['credits']), $styleTextCellBody, $cellHBodyCentered);
                }
                $table->addRow(250, ['exactHeight' => true]);
                $table->addCell(1000, $styleCellBody)->addText();
                $table->addCell(10000, $styleCellBody)->addText('TOTAL', array('bold' => true, 'name' => 'Arial', 'size' => 9), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
                $table->addCell(2000, $styleCellBody)->addText($sumPairCourseCredits, $styleTextCellBody, $cellHBodyCentered);

                $seccion->addText(
                    '',
                    array('name' => 'Arial', 'size' => 10),
                    array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
                );
            }
            if (!empty($missingCoursesOdd)) {
                $seccion->addText(
                    'SEMESTRE IMPAR',
                    array('name' => 'Arial', 'size' => 10, 'bold' => true),
                    array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
                );




                // Crear la tabla HTML
                //                 $html1 = '
                // <table style="border-collapse: collapse; border: 0.1px solid grey;">
                //   <tr style="height: 20px; text-align: center; vertical-align: middle;">
                //     <th style="width: 300px; text-align: center; font-weight: bold; padding: 0;  ">CODIGO</th>
                //     <th style="width: 2000px; text-align: center; font-weight: bold; padding: 0; ">CURSO</th>
                //     <th style="width: 300px; text-align: center; font-weight: bold; padding: 0;  ">CREDITOS</th>
                //   </tr>';

                //                 // Recorrer el array $missingCoursesOdd y agregar cada curso a la tabla
                //                 foreach ($missingCoursesOdd as $curso) {
                //                     $html1 .= '
                //   <tr style="height: 13px; text-align: center; vertical-align: middle;">
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0; font-size: 11px">' . mb_strtoupper($curso['code']) . '</td>
                //     <td style="width: 2000px; text-align: left; border: 0.1px solid grey; padding: 0; margin: 0;font-size: 11px ">' . mb_strtoupper($curso['name']) . '</td>
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0; font-size: 11px">' . $curso['credits'] . '</td>
                //   </tr>';
                //                 }

                //                 // Agregar la fila de totales
                //                 $html1 .= '
                //   <tr style="height: 18px; text-align: center; vertical-align: middle;">
                //     <td style="width: 300px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0; font-size: 11px"></td>
                //     <td style="width: 300px; text-align: right; font-weight: bold; padding: 0;font-size: 12px">TOTAL</td>
                //     <td style="width: 300px; text-align: center; font-weight: bold; padding: 0;font-size: 12px">' . $sumOddCourseCredits . '</td>
                //   </tr>';

                //                 $html1 .= '</table>';

                //                 \PhpOffice\PhpWord\Shared\Html::addHtml($seccion, $html1);

                $table = $seccion->addTable(['width' => 10000, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);
                $tableStyle = array(
                    'borderSize'  => 3,
                    'cellMargin' => 20,
                    'width'       => 300,
                    'cellMarginRight' => 20,
                    'cellMarginBottom' => 10,
                    'cellMarginLeft' => 50,
                    'borderColor' => '666666',
                    'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
                );

                $fancyTableFirstRowStyle = ['borderBottomSize' => 6, 'borderBottomColor' => '0000FF', 'bgColor' => 'bdbebd'];
                $documento->addTableStyle('myTable3', $tableStyle, $fancyTableFirstRowStyle);
                $table = $seccion->addTable('myTable3');
                $styleTextCellHeader = array('bold' => true, 'name' => 'Arial', 'size' => 9);
                $styleTextCellBody = array('name' => 'Arial', 'size' => 8);
                $cellHCentered = array('bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
                $cellHBodyCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
                $cellVCentered = ['valign' => 'center'];
                // Add the table headers
                $table->addRow(250, ['exactHeight' => true]);
                $table->addCell(null, $cellVCentered)->addText('CODIGO', $styleTextCellHeader, $cellHCentered);

                $table->addCell(null, $cellVCentered)->addText('NOMBRE', $styleTextCellHeader, $cellHCentered);

                $table->addCell(null, $cellVCentered)->addText('CREDITOS', $styleTextCellHeader, $cellHCentered);
                // Set the row height


                // Add the table data

                foreach ($missingCoursesOdd as $item => $course) {


                    $styleCellBody = array('valign' => 'center');


                    $table->addRow(250, ['exactHeight' => true]);
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['code']), $styleTextCellBody, $cellHBodyCentered);
                    $table->addCell(10000, $styleCellBody)->addText(mb_strtoupper($course['name']), $styleTextCellBody);
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['credits']), $styleTextCellBody, $cellHBodyCentered);
                }
                $table->addRow(250, ['exactHeight' => true]);
                $table->addCell(1000, $styleCellBody)->addText();
                $table->addCell(10000, $styleCellBody)->addText('TOTAL', array('bold' => true, 'name' => 'Arial', 'size' => 9), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::END));
                $table->addCell(2000, $styleCellBody)->addText($sumOddCourseCredits, $styleTextCellBody, $cellHBodyCentered);
            }
        } else {
        }

        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );

        $seccion->addText(
            'la ' . $configuration->commission_name . ', acuerda según:',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $agreement_number = $configuration->agreement_number; 

        $length = strlen((string) $agreement_number);

        if ($length == 1) {
            $agreement_number = str_pad($agreement_number, 4, "0", STR_PAD_LEFT);
        } elseif ($length == 2) {
            $agreement_number = str_pad($agreement_number, 4, "0", STR_PAD_LEFT);
        } elseif ($length == 3) {
            $agreement_number = str_pad($agreement_number, 4, "0", STR_PAD_LEFT);
        }
        $year = Carbon::now()->year;

        $seccion->addText(
            'Acuerdo ' . $agreement_number . '-' . $year . '-' . $configuration->abbreviation . '/' . mb_strtoupper($configuration->faculty->abbreviation),
            array('name' => 'Arial', 'size' => 12, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        foreach ($articles as $article) {
            if (!empty($article['name'])) {
                // Agregar una nueva sección al documento
                $textrun = $seccion->addTextRun();
                // Agregar el nombre del artículo (en negrita) y la descripción a la sección
                $textrun->addText(
                    $article['name'] . '. - ',
                    array('name' => 'Arial', 'size' => 10, 'bold' => true)
                );

                // Agregar la descripción del artículo
                $textrun->addText(
                    $article['description'],
                    array('name' => 'Arial', 'size' => 10, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::BOTH)
                );

                // Agregar una fila en blanco
                $seccion->addText(
                    '',
                    array('name' => 'Arial', 'size' => 10),
                    array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
                );
            }
        }
        $seccion->addText(
            'Atentamente,',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        // Agregar el texto al documento con el formato especificado
        $seccion->addText(
            mb_strtoupper($configuration->university),
            array('name' => 'Calibri', 'size' => 5.5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            'FACULTAD DE ' . mb_strtoupper($configuration->faculty->name),
            array('name' => 'Calibri', 'size' => 4, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Bookman Old Style', 'size' => 4),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Bookman Old Style', 'size' => 4),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            "______________________________________",
            array('name' => 'Bookman Old Style', 'size' => 6, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            $configuration->president_name,
            array('name' => 'Bookman Old Style', 'size' => 6.5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            "PRESIDENTE",
            array('name' => 'Bookman Old Style', 'size' => 5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            mb_strtoupper($configuration->commission_name),
            array('name' => 'Bookman Old Style', 'size' => 4, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );
        $seccion = $documento->addSection($sectionStyle);
        $seccion->addText(
            'SEGUIMIENTO CURRICULAR DE LA ' .  mb_strtoupper($configuration->faculty->abbreviation) . ' POR AREAS CORRESPONDIENTES AL ALUMNO(A): ' .  mb_strtoupper($userPetition->user_petition->surname) . ', ' . mb_strtoupper($userPetition->user_petition->name) . ' (' . mb_strtoupper($userPetition->user_petition->code) . ')',
            array('name' => 'Arial', 'size' => 10, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        //         $html = '
        // <table style="border-collapse: collapse; border: 0.1px solid grey;">
        //   <tr style="height: 20px; text-align: center; vertical-align: middle;">
        //     <th style="text-align: center; font-weight: bold; ">CODIGO</th>
        //     <th style="width: 2000px; text-align: center; font-weight: bold; padding: 0; ">CURSO</th>
        //     <th style="text-align: center; font-weight: bold; padding: 2;">CRED</th>
        //     <th style="text-align: center; font-weight: bold; padding: 2;">NOTA</th>
        //     // <th style="text-align: center; font-weight: bold; padding: 2;">SEMES</th>
        //     <th style="text-align: center; font-weight: bold; padding: 2;">TIPO</th>
        //   </tr>';


        //         foreach ($backup as $record => $courses) {
        //             // Si $courses no está vacío, entonces imprime $record y los cursos
        //             if (!empty($courses)) {
        //                 $html .= '
        //       <tr style="height: 20px; text-align: center; vertical-align: middle;">
        //         <td colspan="6" style="text-align: left; border: 0.1px solid grey; padding: 0; margin: 0; font-weight: bold;font-size: 12px">' . mb_strtoupper($record) . '</td>
        //       </tr>';
        //                 foreach ($courses as $item => $course) {
        //                      $color = '';
        //                 if ($course['tipo_curso'] == 'actividad_libre') {
        //                      $color = 'background-color: #FFFFCC;';
        //                  } elseif ($course['tipo_curso'] == 'electivo') {
        //                      $color = 'background-color: #FFD433;';
        //                  }
        //                     $tipo = '';
        //                     if (isset(Course::TYPECOURSE[$course['tipo_curso']])) {
        //                         $tipo =  mb_strtoupper(Course::TYPECOURSE[$course['tipo_curso']]);
        //                     } else {
        //                         $tipo = 'NO ASIGNADO';
        //                     }


        //                     $html .= '
        //           <tr style="' . $color . ';height: 13px;  vertical-align: middle;">
        //             <td style="text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;white-space: nowrap;font-size: 11px">' . mb_strtoupper($course['codigo']) . '</td>
        //             <td style="width: 2000px;  border: 0.1px solid grey; white-space: nowrap;font-size: 11px; padding: 0 10px 0 0; mso-padding-alt: 0 10px 0 0;">' . mb_strtoupper($course['nombre']) . '</td>
        //             <td style="text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;white-space: nowrap;font-size: 11px">' . $course['creditos'] . '</td>
        //             <td style="text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;white-space: nowrap;font-size: 11px">' . $course['nota'] . '</td>
        //             <td style="text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;white-space: nowrap;font-size: 11px">' . $course['semestre'] . '</td>
        //             <td style="width: 500px; text-align: center; border: 0.1px solid grey; padding: 0; margin: 0;white-space: nowrap;font-size: 11px">' . $tipo . '</td>
        //           </tr>';
        //                 }
        //             }
        //         }

        //         $html .= '</table>';

        //         \PhpOffice\PhpWord\Shared\Html::addHtml($seccion, $html);
        $table = $seccion->addTable(['width' => 10000, 'unit' => 'pct', 'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER]);
        $tableStyle = array(
            'borderSize'  => 3,
            'cellMargin' => 20,
            'width'       => 300,
            'cellMarginRight' => 20,
            'cellMarginBottom' => 20,
            'cellMarginLeft' => 50,
            'borderColor' => '666666',
            'alignment' => \PhpOffice\PhpWord\SimpleType\JcTable::CENTER,
        );

        $fancyTableFirstRowStyle = ['borderBottomSize' => 6, 'borderBottomColor' => '0000FF', 'bgColor' => 'bdbebd'];
        $documento->addTableStyle('myTable4', $tableStyle, $fancyTableFirstRowStyle);
        $table = $seccion->addTable('myTable4');
        $styleTextCellHeader = array('bold' => true, 'name' => 'Arial', 'size' => 9);
        $styleTextCellBody = array('name' => 'Arial', 'size' => 8);
        $cellHCentered = array('bold' => true, 'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellHBodyCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = ['valign' => 'center'];
        // Add the table headers
        $table->addRow(250, ['exactHeight' => true]);
        $table->addCell(null, $cellVCentered)->addText('CODIGO', $styleTextCellHeader, $cellHCentered);

        $table->addCell(null, $cellVCentered)->addText('NOMBRE', $styleTextCellHeader, $cellHCentered);

        $table->addCell(null, $cellVCentered)->addText('CRED', $styleTextCellHeader, $cellHCentered);

        $table->addCell(null, $cellVCentered)->addText('NOTA', $styleTextCellHeader, $cellHCentered);
        $table->addCell(null, $cellVCentered)->addText('SEMES', $styleTextCellHeader, $cellHCentered);
        $table->addCell(null, $cellVCentered)->addText('TIPO', $styleTextCellHeader, $cellHCentered);
        // Set the row height


        // Add the table data
        foreach ($backup as $record => $courses) {
            // Si $courses no está vacío, entonces imprime $record y los cursos
            if (!empty($courses)) {
                $cellVAreaStyle = ['valign' => 'center', 'bgColor' => 'e9e9e9'];
                $table->addRow(250, ['exactHeight' => true]);
                $cell = $table->addCell(null, $cellVAreaStyle);
                $cell->getStyle()->setGridSpan(6);
                $cell->addText(mb_strtoupper($record), $styleTextCellHeader, null);

                foreach ($courses as $item => $course) {
                    $tipo = '';
                    if (isset(Course::TYPECOURSE[$course['tipo_curso']])) {
                        $tipo =  mb_strtoupper(Course::TYPECOURSE[$course['tipo_curso']]);
                    } else {
                        $tipo = 'NO ASIGNADO';
                    }
                    $color = '';
                    if ($course['tipo_curso'] == 'actividad_libre') {
                        $styleCellBody = array('valign' => 'center', 'bgColor' => 'fef580');
                    } elseif ($course['tipo_curso'] == 'electivo') {
                        $styleCellBody = array('valign' => 'center', 'bgColor' => 'ffd8a7');
                    } else {

                        $styleCellBody = array('valign' => 'center');
                    }

                    $table->addRow(250, ['exactHeight' => true], ['bgColor' => 'yellow']);
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['codigo']), $styleTextCellBody, $cellHBodyCentered);
                    $table->addCell(5000, $styleCellBody)->addText(mb_strtoupper($course['nombre']), $styleTextCellBody);
                    $table->addCell(1000, $styleCellBody)->addText($course['creditos'], $styleTextCellBody, $cellHBodyCentered);
                    if($course['nota']<10.5){
                        $table->addCell(1000, array('valign' => 'center', 'bgColor' => 'ffc6c4'))->addText($course['nota'], $styleTextCellBody, $cellHBodyCentered);
                        
                    }else{
                        $table->addCell(1000, $styleCellBody)->addText($course['nota'], $styleTextCellBody, $cellHBodyCentered);

                    }
                    $table->addCell(1000, $styleCellBody)->addText(mb_strtoupper($course['semestre']), $styleTextCellBody, $cellHBodyCentered);
                    $table->addCell(2000, $styleCellBody)->addText(mb_strtoupper($tipo), $styleTextCellBody, $cellHBodyCentered);
                }
            }
        }


        $seccion->addText(
            '',
            array('name' => 'Arial', 'size' => 10),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        // Agregar el texto al documento con el formato especificado
        $seccion->addText(
            mb_strtoupper($configuration->university),
            array('name' => 'Calibri', 'size' => 5.5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            'FACULTAD DE ' . mb_strtoupper($configuration->faculty->name),
            array('name' => 'Calibri', 'size' => 4, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Bookman Old Style', 'size' => 4),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            '',
            array('name' => 'Bookman Old Style', 'size' => 4),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::START, 'spaceAfter' => 0)
        );
        $seccion->addText(
            "______________________________________",
            array('name' => 'Bookman Old Style', 'size' => 6, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            $configuration->president_name,
            array('name' => 'Bookman Old Style', 'size' => 6.5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            "PRESIDENTE",
            array('name' => 'Bookman Old Style', 'size' => 5, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );

        $seccion->addText(
            mb_strtoupper($configuration->commission_name),
            array('name' => 'Bookman Old Style', 'size' => 4, 'bold' => true),
            array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 0)
        );
        
        $nombreDcouemnto = $userPetition->user_petition->code . '-' . $agreement_number . '.docx';
        $filename = public_path($nombreDcouemnto);
        $documento->save($filename);
        $userPetition->agreement_number=$agreement_number;
        $userPetition->configuration=array($configuration);
        $userPetition->state_petition=6;
        $userPetition->processing_status=4;

        $userPetition->save();
        return [
            'filename' => $nombreDcouemnto,
            'filepath' => $filename
        ];
    }
}
