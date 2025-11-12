<script>
    // select html elements
    const wrapperEl = document.querySelector('.wrapper');
    const startBtnEl = document.querySelector('.start-btn');
    const timerBoxEl = document.querySelector('.timer');
    const timerTimeEl = document.querySelector('.timer-time');
    const timerTextEl = document.querySelector('.timer-text');
    const h1El = document.querySelector('h1');
    const warmUpMsgEl = document.querySelector('.message');
    const roundBoxEl = document.querySelector('.round');
    const currentRoundEl = roundBoxEl.querySelector('.current-round');
    const exercisesEl = document.querySelector('.exercises');
    const totalTimeEl = document.querySelector('.total-time');

    let secondsToPrepare = 8;
    const formsDisplacement = '-250px'; // by x axis
    let workoutTimer; // for interval timer
    let workoutTime = 0; // for current stage of workout
    let workoutTotalTime = 0; // workout overall
    let currentRoundIndex = 0;
    let currentExerciseIndex = 0;
    let nowIsWork = true; // either work/exercise or rest time

    // grab stuff passed by php
    let totalTimeSeconds = +wrapperEl.dataset.totalTime;
    let workTimeSeconds = +wrapperEl.dataset.workTime;
    let restTimeSeconds = +wrapperEl.dataset.restTime;
    let roundsNum = +wrapperEl.dataset.rounds;
    const exercisesArr = JSON.parse(wrapperEl.dataset.exercises).map(el => el.replace('\r', ''));
    const exercisesInRoundNum = exercisesArr.length;

    // dev mode, testing purposes
    workTimeSeconds = 7;
    restTimeSeconds = 7;
    roundsNum = 2;

    const myVoice = 'Alex';
    // const myVoice = 'Samantha';

    // on clicking Start btn - workout begins
    startBtnEl.addEventListener('click', beginWorkout)

    // ==========================================================================================

    async function beginWorkout () {
        // remove warm up msg 
        warmUpMsgEl.classList.add('opacity-0');
        setTimeout(() => { warmUpMsgEl.remove() }, 700)
        
        // move blocks a bit
        wrapperEl.style.transform = `translateX(${formsDisplacement}`;
        h1El.style.transform = `translateX(${formsDisplacement}`;

        // darken bg for better contrast
        exercisesEl.classList.remove('bg-gray-800/70');
        exercisesEl.classList.add('bg-black/70', 'border', 'border-2', 'border-gray-500');

        // enlarge elements for better visibility
        roundBoxEl.classList.remove('text-2xl');
        roundBoxEl.classList.add('text-[45px]');
        exercisesEl.classList.remove('text-[20px]');
        exercisesEl.classList.add('text-[35px]');
        
        // give n seconds to prepare
        await showPrepareTimer();

        // start ticking, main workout time
        await workout();

        finishWorkout();
    }

    // ==========================================================================================

    async function workout () {
        let inMins, remainingSecs;
        let inMinsTotal, remainingSecsTotal;
        printWorkoutStartEnd('start'); // print when started
        speak('Go!', myVoice); // audial command
        return new Promise((resolve, reject) => {
            workoutTime = workTimeSeconds; // after 'get ready' secs are over, it starts w/ exercise time (work time)
            paintTimer('work');
            convertAndShow(workoutTime, timerTimeEl);
            convertAndShow(workoutTotalTime, totalTimeEl);
            highlightCurrentExercise();

            workoutTimer = setInterval(() => {
                // log total time counting up
                workoutTotalTime += 1;
                convertAndShow(workoutTotalTime, totalTimeEl);

                // log current workout stage time counting down
                workoutTime -= 1;
                highlightCurrentExercise();

                // say something 5 secs before work time:
                let isLastInRound = currentExerciseIndex+1 === exercisesInRoundNum;
                let isLastRound = currentRoundIndex === roundsNum -1;
                if (workoutTime === 5 && !nowIsWork) {
                    if (isLastInRound && !isLastRound) {
                        speak(`Next exercise: ${exercisesArr[0]}.`, myVoice);
                    } else if (isLastInRound && isLastRound) {
                        console.log(`it's done`);
                    } else {
                        speak(`Next exercise: ${exercisesArr[currentExerciseIndex+1]}.`, myVoice);
                    }
                }

                if (workoutTime < 0) {
                    // change current stage timer to work/rest time
                    if (nowIsWork) { 
                        // work done, time to rest
                        workoutTime = restTimeSeconds;
                        nowIsWork = !nowIsWork; // flip it
                        timerTextEl.textContent = 'Rest';
                        paintTimer('rest');
                        convertAndShow(workoutTime, timerTimeEl);
                        speak(`Rest.`, myVoice);
                        highlightCurrentExercise(); // to de-highlight all temporarily
                    } else { 
                        // rest done, time to work
                        if (currentRoundIndex < roundsNum) {
                            speak('Go!', myVoice);
                        }
                        workoutTime = workTimeSeconds;
                        nowIsWork = !nowIsWork; // flip it
                        timerTextEl.textContent = 'Work';
                        paintTimer('work');
                        convertAndShow(workoutTime, timerTimeEl);
                        currentExerciseIndex += 1; // increment current exercise index

                        // check current exercise count
                        if (currentExerciseIndex === exercisesInRoundNum) {
                            currentExerciseIndex = 0; // reset exercises
                            currentRoundIndex += 1; // increment round
                            // check current round count -- proceed or finish workout
                            if (currentRoundIndex === roundsNum) {
                                resolve(); // finishes it
                                return;
                            } else {
                                incrementRound(); // proceed
                                speak(`Round ${currentRoundIndex+1}.`, myVoice);
                            }
                        }
                        highlightCurrentExercise();
                    }
                } else {
                    convertAndShow(workoutTime, timerTimeEl);
                }
            }, 1000);
        })
    }

    // ==========================================================================================

    // visually highlight/de-highlight exercises
    function highlightCurrentExercise () {
        if (!nowIsWork) { // de-highlight all when rest
            exercisesEl.querySelectorAll('.exercise').forEach((el, ind) => {
                el.style.opacity = 0.3;
            })
        } else { // highlight one when work
            exercisesEl.querySelectorAll('.exercise').forEach((el, ind) => {
                if (currentExerciseIndex === ind) el.style.opacity = 1;
                else el.style.opacity = 0.3;
            })
        }
    }

    // ==========================================================================================

    // when workout is over
    function finishWorkout () {
        clearInterval(workoutTimer);

        // reset text
        timerTimeEl.textContent = `00:00`;
        timerTextEl.textContent = 'Finished!';
        
        // reset styles
        timerBoxEl.classList.remove('text-[limegreen]', 'text-[yellow]');
        timerBoxEl.classList.add('text-[antiquewhite]');
        timerBoxEl.style.textShadow = '0 0 4px antiquewhite';

        // visually highlight all exercises
        exercisesEl.querySelectorAll('.exercise').forEach((el, ind) => {
            el.style.opacity = 1;
        })
        
        // print real world time when ended
        printWorkoutStartEnd('end');

        // say how long it took
        const [tookMins,tookSecs] = totalTimeEl.textContent.split(':');
        speak(`Workout finished! Well done! 
            It took ${+tookMins} minutes, ${+tookSecs} seconds. 
            Now it is ${new Intl.DateTimeFormat('en-US', { hour: '2-digit', minute: '2-digit' }).format(new Date())}.`, myVoice);
    }

    // ==========================================================================================

    // increment rounds
    function incrementRound () {
        // const curValue = +currentRoundEl.textContent;
        // currentRoundEl.textContent = curValue+1;
        currentRoundEl.textContent = currentRoundIndex + 1;
    }

    // ==========================================================================================

    // change text color on timer, visual cue (work/rest time)
    function paintTimer (flag) {
        if (flag === 'work') {
            timerBoxEl.classList.remove('text-[limegreen]');
            timerBoxEl.classList.add('text-[yellow]');
            timerBoxEl.style.textShadow = '0 0 4px yellow';
        } else {
            timerBoxEl.classList.remove('text-[yellow]');
            timerBoxEl.classList.add('text-[limegreen]');
            timerBoxEl.style.textShadow = '0 0 4px limegreen';
        }
    }

    // ==========================================================================================

    // padStart a value
    const padIt = (val) => val.toString().padStart(2, '0');

    // ==========================================================================================

    // convert raw seconds to minutes-seconds and render it
    function convertAndShow (value, element) {
        const [inMins, remainingSecs] = getInMinsAndSecs(value);
        element.textContent = padIt(inMins) + ':' + padIt(remainingSecs);
    }

    // ==========================================================================================

    // convert raw seconds to minutes-seconds
    function getInMinsAndSecs (numOfSecs) {
        const inMins = Math.floor(numOfSecs / 60);
        const remainingSecs = Math.floor(numOfSecs % 60);
        return [inMins, remainingSecs];
    }

    // ==========================================================================================

    // give n seconds to prepare
    async function showPrepareTimer () {
        speak('Get ready!', myVoice);
        return new Promise((resolve, reject) => {
            timerBoxEl.classList.remove('invisible', 'opacity-0'); // make visible
            timerTimeEl.textContent = '00:' + padIt(secondsToPrepare);
            timerBoxEl.classList.add('text-[coral]');
            timerBoxEl.style.textShadow = '0 0 4px coral';
            timerTextEl.textContent = 'Get Ready!';

            const prepareTimer = setInterval(() => {
                secondsToPrepare -= 1; // start ticking
                timerTimeEl.textContent = '00:' + padIt(secondsToPrepare);
                if (secondsToPrepare === 6) {
                    speak(`Workout begins now. Round ${currentRoundIndex+1}. Exercise: ${exercisesArr[currentExerciseIndex]}.`, myVoice);
                }
                if (secondsToPrepare === 0) { // stop Get Ready timer
                    clearInterval(prepareTimer);
                    timerTextEl.textContent = 'Work';
                    resolve();
                }
            }, 1000); // every sec
        });
    }

    // ==========================================================================================

    // print when it started and then when it ended
    function printWorkoutStartEnd (flag) {
        const now = new Intl.DateTimeFormat('en-US', { hour: '2-digit', minute: '2-digit' }).format(new Date());
        const word = flag === 'start' ? 'Started at' : 'Ended at';
        if (!document.querySelector('.start-end')) { // insert container element
            document.querySelector('main').insertAdjacentHTML('afterend', '<div class="start-end flex gap-12 justify-center mb-4 opacity-40 hover:opacity-100 transition duration-300"></div>')
        }
        document.querySelector('.start-end').insertAdjacentHTML('beforeend', `<div class="text-white">${word}: ${now}</div>`)        
    }

    // ==========================================================================================

    // say something
    function speak(text, voiceName = 'Alex') {
        const utter = new SpeechSynthesisUtterance(text);
        if (voiceName) {
            const voice = speechSynthesis.getVoices().find(v => v.name === voiceName);
            if (voice) utter.voice = voice;
        }
        speechSynthesis.speak(utter);
    }

</script>
