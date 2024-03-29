<?php
class StudentFunctions{
    private $db;  
    private $classroom;
    
    public function StudentFunctions(){
        global $wpdb;
        $this->db = $wpdb;
        $this->classroom = $this->get_classroom();
        
        // Shortcodes
        add_shortcode('lessons', array(&$this, 'industry_lessons') );
        add_shortcode('lesson', array(&$this, 'industry_lesson') );
        add_shortcode('results', array(&$this, 'industry_results') );
        add_shortcode('student', array(&$this, 'industry_student') );
        add_shortcode('eartrainer', array(&$this, 'industry_eartrainer') );
        add_shortcode('eartrainer_view', array(&$this, 'industry_eartrainer_view') );
        
        add_action('wp_ajax_processor', array(&$this, 'industry_ajax_processor') );
        add_action('wp_ajax_nopriv_processor', array(&$this, 'industry_ajax_processor') );
        
    } 
    
    //[student] shortcode - Holds all dashboard modules
    public function industry_student(){
        $lessons = $this->get_all_lessons();
        
        ob_start();
        include '_student_dashboard.php';
        return ob_get_clean();
    }
    
    public function prepare_eartrainer($exerciseType){
        switch($exerciseType){
            case 'note_identification':
                $sql = "SELECT answer FROM ear_trainer WHERE exercise_type = 'note_identification' ORDER BY RAND() LIMIT 1";
                break;
            case 'interval_recognition':
                $sql = "SELECT answer FROM ear_trainer WHERE exercise_type = 'interval_recognition' ORDER BY RAND() LIMIT 1";
                $sql2 = "SELECT answer FROM ear_trainer WHERE exercise_type = 'note_identification' ORDER BY RAND() LIMIT 1";
                break;
            case 'chord_recognition':
                $sql = "SELECT answer FROM ear_trainer WHERE exercise_type = 'chord_recognition' ORDER BY RAND() LIMIT 1";
                $sql2 = "SELECT answer FROM ear_trainer WHERE exercise_type = 'note_identification' ORDER BY RAND() LIMIT 1";
                break;
        }
        
        $eartrainerAnswers = [];
        $eartrainerQuestions = [];
        for ($i = 0; $i < 50; $i++) {
            $randomAnswer = $this->db->get_results($sql);
            $eartrainerAnswers[$i] = $randomAnswer[0]->answer;     
        }
        
        if($sql2){
            for ($i = 0; $i < 50; $i++) {
                $randomQuestions = $this->db->get_results($sql2);
                $eartrainerQuestions[$i] = $randomQuestions[0]->answer;     
            }
            
        }else{
            $eartrainerQuestions = $eartrainerAnswers;
        }
        
        $lessonQuestions = [];
    
        for ($i = 0; $i < count($eartrainerAnswers); $i++) {
            $lessonQuestions[$i] = new stdClass();
            
            $lessonQuestions[$i]->lesson_name = 'Ear Trainer: ' . $exerciseType;
            $lessonQuestions[$i]->exercise_type = $exerciseType;
            $lessonQuestions[$i]->question = $eartrainerQuestions[$i];
            $lessonQuestions[$i]->answer = $eartrainerAnswers[$i];
        }
        
        return $lessonQuestions;
    }
    
    //[eartrainer_view] shortcode
    public function industry_eartrainer_view(){
        $exercise_type = $_GET['type'];
        
        $lessonQuestions = $this->prepare_eartrainer($exercise_type);
        
        ob_start();
        include '_lesson_questions.php';
        return ob_get_clean();
    }
    
    //[eartrainer] shortcode
    public function industry_eartrainer(){
        ob_start();
        include '_student_eartrainer.php';
        return ob_get_clean();
    }
    
    /**
     * Takes in results and student answers and
     * returns full words
     **/
    public function answer_filter($answer){
        switch($answer){
            case 'maj':
                $filtered = 'Major';
                break;
            case 'min':
                $filtered = 'Minor';
                break;
            case 'aug':
                $filtered = 'Augmented';
                break;
            case 'dim_7':
                $filtered = 'Diminished 7th';
                break;
            case 'dom_7':
                $filtered = 'Dominant 7th';
                break;
            case 'maj_7':
                $filtered = 'Major 7th';
                break;
            case 'min_7':
                $filtered = 'Minor 7th';
                break;
            case 'min_2':
                $filtered = 'Minor 2nd';
                break;
            case 'maj_2':
                $filtered = 'Major 2nd';
                break;
            case 'min_3':
                $filtered = 'Minor 3rd';
                break;
            case 'maj_3':
                $filtered = 'Major 3rd';
                break;
            case 'per_4':
                $filtered = 'Perfect 4th';
                break;
            case 'aug_4':
                $filtered = 'Tritone';
                break;
            case 'per_5':
                $filtered = 'Minor 5th';
                break;
            case 'min_6':
                $filtered = 'Minor 6th';
                break;
            case 'maj_6':
                $filtered = 'Major 6th';
                break;
            case 'oct':
                $filtered = 'Octave';
                break;
            case 'a':
                $filtered = 'A';
                break;
            case 'a#':
                $filtered = 'A#';
                break;
            case 'b':
                $filtered = 'B';
                break;
            case 'c':
                $filtered = 'C';
                break;
            case 'c#':
                $filtered = 'C#';
                break;
            case 'd':
                $filtered = 'D';
                break;
            case 'd#':
                $filtered = 'D#';
                break;
            case 'e':
                $filtered = 'E';
                break;
            case 'f':
                $filtered = 'F';
                break;
            case 'f#':
                $filtered = 'F#';
                break;
            case 'g':
                $filtered = 'G';
                break;
            case 'g#':
                $filtered = 'G#';
                break;
        }
        return $filtered;
    }
    
    public function get_all_lessons(){
        $sql = "SELECT lesson_id, lesson_name FROM lessons WHERE classroom_name = '" . $this->classroom . "'";
        
        $studentsLessons = $this->db->get_results($sql, ARRAY_A);
        //die(var_dump($studentsLessons[0]['lesson_id']) );
        $lessons = [];
        
        foreach($studentsLessons as $lesson){
            $lessons[$lesson['lesson_id']]['lesson_name'] = $lesson['lesson_name'];
            
            $sql = "SELECT answer FROM exercises WHERE lesson_id = '" . $lesson['lesson_id'] . "'";
            $answers = $this->db->get_results($sql, ARRAY_A);
            $filteredAnswers = [];
            
            $sql = "SELECT student_answer FROM results WHERE lesson_id = '" . $lesson['lesson_id'] . "'";
            $studentAnswers = $this->db->get_results($sql, ARRAY_A);
            
            // Filtering database answers to user-friendly answers
            for ($i = 0; $i < count($answers); $i++) {
                 $filteredAnswers[$i]['answer'] = $this->answer_filter($answers[$i]['answer']);
                 $filteredStudentAnswers[$i]['student_answer'] = $this->answer_filter($studentAnswers[$i]['student_answer']);
            }
            
            $lessons[$lesson['lesson_id']]['answers'] = $filteredAnswers;
            $lessons[$lesson['lesson_id']]['studentAnswers'] = $filteredStudentAnswers; 
        }
        return $lessons;
    }
    
    public function industry_results(){
        $lessonId = $_GET['lesson'];
        $results = [];
        
        // Grab the answers for the lesson being shown.
        $sql = "SELECT answer FROM exercises WHERE lesson_id = '" . $lessonId . "'";
        $answers = $this->db->get_results($sql, ARRAY_A);
        // Grab the students answers from the lesson being shown.
        $sql = "SELECT student_answer FROM results WHERE lesson_id = '" . $lessonId . "'";
        $studentAnswers = $this->db->get_results($sql, ARRAY_A);
        
        for ($i = 0; $i < count($answers); $i++) {
             $results[$i]['answer'] = $this->answer_filter($answers[$i]['answer']);
             $results[$i]['studentAnswer'] = $this->answer_filter($studentAnswers[$i]['student_answer']);
        }
        
        $lessonName = $this->db->get_results("SELECT lesson_name FROM lessons WHERE lesson_id = '" . $lessonId . "'");
        
        $sql = "SELECT correct 
                    FROM results 
                    WHERE lesson_id = '" . $lessonId . "' 
                    AND student_id = '" . get_current_user_id() . "'
                    AND correct = '1'";
                              
        $score = $this->db->query($sql);
       
        $results['lesson_name'] = $lessonName;
        $results['score'] = $score;
        
        
        ob_start();
        include '_results.php';
        return ob_get_clean();
    }
    
    //[lesson] shortcode
    public function industry_lesson(){
        $lessonId = $_GET['lesson'];
        
        $sql = "SELECT *
                FROM lessons
                INNER JOIN exercises
                ON lessons.lesson_id=exercises.lesson_id
                WHERE lessons.lesson_id = '" . $lessonId . "'";
                
        $lessonQuestions = $this->db->get_results($sql);
        
        ob_start();
        include '_lesson_questions.php';
        return ob_get_clean();
        
        // $lessonData = [];
        // $lessonData['lesson_id'] = $lessonId;
        // $lessonData['lesson_name'] = $lessonQuestions[0]['lesson_name'];
        // $lessonData['exercise_type'] = $lessonQuestions[0]['exercise_type'];
        
        // for($i = 0; $i < count($lessonQuestions); $i++){
        //     $lessonData['question'][$i] = $lessonQuestions[$i]['question'];
        //     $lessonData['answer'][$i] = $lessonQuestions[$i]['answer'];
        // }
        
        // ob_start();
        // include '_lesson_questions.php';
        // return ob_get_clean();
    }
    
    // [lessons] shortcode
    public function industry_lessons(){
        $lessons = $this->get_all_lessons_filtered_past_current();
        //die(var_dump($lessons['current_lessons']));
        ob_start();
        include '_lessons.php';
        return ob_get_clean();
    }
    
    public function get_classroom(){
        return get_user_meta(get_current_user_id(), 'classroom', true);
    }
    
    public function get_all_lessons_filtered_past_current(){
        
        $sql = "SELECT lesson_id FROM lessons WHERE classroom_name = '" . $this->classroom . "'";
        $studentLessonIds = $this->db->get_results($sql, ARRAY_A);
        
        $studId = [];
        for ($i = 0; $i < count($studentLessonIds); $i++) {
             $studId[$i] = $studentLessonIds[$i]['lesson_id'];
        }
        
        // Getting the past lessons
        $pastLessons = [];
        $pastLessonIds = get_user_meta(get_current_user_id(), 'lesson_completed');
        
        for($i = 0; $i < count($pastLessonIds); $i++ ){
            $sql = "SELECT * FROM lessons WHERE lesson_id = '" . $pastLessonIds[$i] . "'";
            $pastLessons[$i] = $this->db->get_results($sql);
            
            $sql = "SELECT correct 
                    FROM results 
                    WHERE lesson_id = '" . $pastLessonIds[$i] . "' 
                    AND student_id = '" . get_current_user_id() . "'
                    AND correct = '1'";
                    
            $pastLessons[$i]['score'] = $this->db->query($sql);
        }
        
        // Getting the current lessons
        
        $currentLessonIds = array_diff($studId, $pastLessonIds);
        $currentLessons = [];
        
        foreach($currentLessonIds as $lessonId){
            $sql = "SELECT * FROM lessons WHERE lesson_id = '" . $lessonId . "'";
            $currentLessons[$lessonId] = $this->db->get_results($sql); 
        }
        
        $lessons = [];
        $lessons['past_lessons'] = $pastLessons;
        $lessons['current_lessons'] = $currentLessons;
        return $lessons;
    }
    
    public function industry_ajax_processor(){
        if($_POST['formData']){
            $data = $_POST['formData'];
            // Routing the type of processing depending on the type of form.
            switch($data['type']){
                case 'enrolment':
                    wp_send_json($this->create_student($data) );
                    break;
                case 'update-student':
                    wp_send_json($this->update_student($data) );
                    break;
                case 'create-classroom':
                    wp_send_json($this->create_classroom($data) );
                    break;
                case 'update-classroom':
                    wp_send_json($this->update_classroom($data) );
                    break;
                case 'create-lesson':
                    wp_send_json($this->create_lesson($data) );
                    break;
                case 'update-lesson':
                    $this->update_lesson();
                    break;
            }
        }
        die(json_encode(array('test' => 'hovercraft is full of eeels')));
    }
}

$studentFunctions = new StudentFunctions();

?>

