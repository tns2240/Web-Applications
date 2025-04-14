const quizData = [
    {
      question: "What is the year of Independence of Bangladesh?",
      answers: ["1947", "1964", "1971", "1990"],
      correct: "1971"
    },
    {
      question: "Which language runs in a web browser?",
      answers: ["Java", "C", "Python", "JavaScript"],
      correct: "JavaScript"
    },
    {
      question: "What is the course code of Web Application course in IUB?",
      answers: ["CSE 303", "CSE 307", "CSE 309", "CSE 313"],
      correct: "CSE 309"
    }
  ];
  
  let currentQuestionIndex = 0;
  let score = 0;
  
  const questionEl = document.getElementById('question');
  const answerButtonsEl = document.getElementById('answer-buttons');
  const nextBtn = document.getElementById('nextBtn');
  const scoreBox = document.getElementById('scoreBox');
  
  function startQuiz() {
    currentQuestionIndex = 0;
    score = 0;
    nextBtn.textContent = "Next";
    showQuestion();
  }
  
  function showQuestion() {
    resetState();
    const currentQuestion = quizData[currentQuestionIndex];
    questionEl.textContent = currentQuestion.question;
  
    currentQuestion.answers.forEach(answer => {
      const button = document.createElement('button');
      button.textContent = answer;
      button.classList.add('answer-btn');
      button.addEventListener('click', selectAnswer);
      answerButtonsEl.appendChild(button);
    });
  }
  
  function resetState() {
    nextBtn.style.display = 'none';
    answerButtonsEl.innerHTML = '';
    scoreBox.textContent = '';
  }
  
  function selectAnswer(e) {
    const selectedBtn = e.target;
    const selectedAnswer = selectedBtn.textContent;
    const correctAnswer = quizData[currentQuestionIndex].correct;
  
    if (selectedAnswer === correctAnswer) {
      selectedBtn.style.backgroundColor = "green";
      score++;
    } else {
      selectedBtn.style.backgroundColor = "red";
    }
  
    Array.from(answerButtonsEl.children).forEach(button => {
      button.disabled = true;
      if (button.textContent === correctAnswer) {
        button.style.backgroundColor = "green";
      }
    });
  
    nextBtn.style.display = 'block';
  }
  
  nextBtn.addEventListener('click', () => {
    currentQuestionIndex++;
    if (currentQuestionIndex < quizData.length) {
      showQuestion();
    } else {
      showScore();
    }
  });
  
  function showScore() {
    resetState();
    questionEl.textContent = "Quiz Finished!";
    scoreBox.textContent = `Your Score: ${score} / ${quizData.length}`;
    nextBtn.textContent = "Restart";
    nextBtn.style.display = 'block';
    nextBtn.addEventListener('click', startQuiz, { once: true });
  }
  
  startQuiz();
  