<table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th class="text-uppercase">Lesson Name</th>
                <th class="text-uppercase">Type of Exercise</th>
                <th class="text-uppercase">Classroom Name</th>
                <th class="text-uppercase">Score</th>
                <th class="text-uppercase">View Results</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($lessons['past_lessons'] as $lesson):?>
            <tr>
                <td><?php echo $lesson[0]->lesson_name ?></td>
                <td><?php echo $lesson[0]->exercise_type ?></td>
                <td><?php echo $lesson[0]->classroom_name ?></td>
                <td><?php echo $lesson['score'] . '/' . $lesson[0]->number_of_questions ?></td>
                <td><a href="<?php echo home_url()?>/student/results?lesson=<?php echo $lesson[0]->lesson_id ?>">View Results</a></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
</table>