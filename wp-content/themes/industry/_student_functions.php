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
        
        add_action('wp_ajax_processor', array(&$this, 'industry_ajax_processor') );
        add_action('wp_ajax_nopriv_processor', array(&$this, 'industry_ajax_processor') );
    } 
    
    // [lessons] shortcode
    public function industry_lessons(){
        $lessons = $this->get_all_lessons_from_student();
        
        ob_start();
        include '_lessons.php';
        return ob_get_clean();
    }
    
    public function get_classroom(){
        return get_user_meta(get_current_user_id(), 'classroom', true);
    }
    
    public function get_all_lessons_from_student(){
        // Selecting all of the lessons attributed to the
        // classroom that the student is in.
        
        // Selecting the current assignments
        
        // Selecting the past assignments
        $sql = "SELECT * FROM lessons WHERE classroom_name = '" . $this->classroom . "' ";
        $lessons = $this->db->get_results($sql, ARRAY_A);    
        for($i = 0; $i < count($lessons); $i++){
            // Need to get the results for lessons which have them..
            $lessons[$i]['score'] = '10/10';
        }
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

