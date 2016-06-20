elifePipeline {
    node("libraries") {
        stage 'Checkout'
        checkout scm

        stage 'Tests'
        def stepsForParallel = [:]
        stepsForParallel["dependencies=lowest"] = {
            node {
                sh 'dependencies=lowest ./project_tests.sh'
            }
        }
        stepsForParallel["normal"] = {
            node {
                sh './project_tests.sh'
            }
        }
        parallel stepsForParallel
    }
}
