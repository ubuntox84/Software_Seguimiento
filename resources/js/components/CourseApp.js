export default ()=>{
    return {
        showIListAddCourse:false,
        courses:[ ],
        course :{ },
        nameAreaKnowledgeFront:'',
        idAreaKnowledgeFront:'',
    
        deleteCourse(course) {
          let position = this.courses.indexOf(course);
    
          this.courses.splice(position, 1);
      },
      updateCourses(course){
        console.log(JSON.parse(JSON.stringify(course)))
        const convertCourseObject = JSON.parse(JSON.stringify(course));
        this.course.id= convertCourseObject.id
        this.course.code= convertCourseObject.code
        this.course.name= convertCourseObject.name
        this.course.credits= convertCourseObject.credits
        this.course.practicalHour= convertCourseObject.practicalHour
        this.course.theoreticalHour= convertCourseObject.theoreticalHour
        this.course.typeCourse= convertCourseObject.typeCourse
        this.course.cycle= convertCourseObject.cycle
      },
        addCourse(course) {
            if(this.validate()){
                    return 
            }
            else{
               if(!this.course.id){
                this.course.id=Date.now()
                this.courses.push(course),
                this.cleanField()
               }
               else{
                this.courses.forEach((element, index) => {
                    if(element.id === this.course.id) {
                        element.code=this.course.code
                        element.name=this.course.name
                        element.credits=this.course.credits
                        element.practicalHour=this.course.practicalHour
                        element.theoreticalHour=this.course.theoreticalHour
                        element.typeCourse =this.course.typeCourse
                        element.cycle =this.course.cycle
                }
               
                });
                 this.course={}
               }
            }
           
      },
        cleanField(){
            this.course = {}
        },
        cleanAfterRegister(){
            
            this.courses =[]
            
        },
        validate(){
            if(
                !this.course.code || 
                !this.course.name || 
                !this.course.theoreticalHour || 
                !this.course.practicalHour || 
                !this.course.credits || 
                !this.course.cycle || 
                !this.course.typeCourse               
                )
                    return true
                

        }
    };
}