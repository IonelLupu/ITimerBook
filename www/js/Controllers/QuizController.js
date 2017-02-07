/**
 * Created by Alexandru on 2/4/2017.
 */

app.controller('QuizController', function ($scope, $state ,$stateParams, Server,toastr) {


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

            // console.log(~~question.answer);

            return ~~question.answer;




        })


        // post here
        Server.post("answers",{answers:answers}).success(function (response) {

            if(response==0){

                toastr.success("Raspunsurile tale au fost inregistrate cu succes! <br> Din pacate nu ai raspuns corect la nici o intrebare .")

                $state.go("app.competition");
            }

            else if (response==1){

                toastr.success("Raspunsurile tale au fost inregistrate cu succes! <br> Ai raspuns corect la o singura intrebare.")

                $state.go("app.competition");
            }

            else toastr.success("Raspunsurile tale au fost inregistrate cu succes! <br> Ai raspuns corect la "+response+" intrebari.")

                $state.go("app.competition");
        })

    }
});
