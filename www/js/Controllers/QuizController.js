/**
 * Created by Alexandru on 2/4/2017.
 */

app.controller('QuizController', function ($scope, $stateParams, Server) {


    Server.get('questions').success(function (questions) {

        $scope.questions = questions.map(function (question) {

            question.answers = [];
            for (var i = 1; i <= 4; i++)
                question.answers.push(question["answer" + i])

            return question
        });


    });

    $scope.sendAnswers = function () {

        var answers = $scope.questions.map(function(question){
            return ~~question.answer;
        })

        console.log(answers);

        // post here
        // Server.post("getQuestions",answers).success(function () {
        //
        //     toastr.success("Raspunsurile tale au fost inregistrate cu succes !")
        //
        // })

    }
});
