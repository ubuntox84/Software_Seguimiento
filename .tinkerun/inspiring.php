<?php
use App\Models\Course;
Course::with('areaKnowledges','prerequisites')->get();
