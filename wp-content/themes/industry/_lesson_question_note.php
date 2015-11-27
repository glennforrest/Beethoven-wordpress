<?php foreach($lessonQuestions as $questionNumber => $question):?>
                                <div class="question-wrapper question-wrapper-<?php echo $questionNumber+1 ?> <?php echo $questionNumber > 0 ? 'question-wrapper--hidden' : '' ?> ">
                                    <div id="interval-question" class="question-container row">
                                        <span class="pull-right question-number">
                                            <?php echo $questionNumber+1; ?>
                                            /
                                            <?php echo count($lessonQuestions) ?>
                                        </span>
                
                                        <div class="question-title">
                                            <span>Question <?php echo $questionNumber+1 ?>: What note is being displayed here?</span>
                                        </div>
                                        <div class="notation-container">
                                            
                                        </div>
                                    </div>
                                    <div id="interval-answer" class="answer-container row">
                                        <div class="question-options">
                                            <button class="lesson-button btn" data-value="a">A</button> 
                                            <button class="lesson-button btn" data-value="a#">A#</button> 
                                            <button class="lesson-button btn" data-value="b">B</button> 
                                            <button class="lesson-button btn" data-value="c">C</button> 
                                            <button class="lesson-button btn" data-value="c#">C#</button> 
                                            <button class="lesson-button btn" data-value="d">D</button> 
                                            <button class="lesson-button btn" data-value="d#">D#</button>
                                            <button class="lesson-button btn" data-value="e">E</button>
                                            <button class="lesson-button btn" data-value="f">F</button>
                                            <button class="lesson-button btn" data-value="f#">F#</button>
                                            <button class="lesson-button btn" data-value="g">G</button>
                                            <button class="lesson-button btn" data-value="g#">G#</button>
                                        </div>
                                        <input type="hidden" class="answer-<?php echo $questionNumber+1 ?>" name="form[answer]" value="<?php echo $question->answer ?>"/>
                                    </div>
                                </div>
                            <?php endforeach ?>