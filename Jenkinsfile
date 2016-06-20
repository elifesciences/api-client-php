elifePipeline {
    node("libraries") {
        def stepsForParallel = [:]
        stepsForParallel["dependencies=lowest"] = {
            stage 'Checkout'
            checkout scm

            stage 'Tests'
            node {
                sh 'dependencies=lowest ./project_tests.sh'
            }
        }
        stepsForParallel["normal"] = {
            stage 'Checkout'
            checkout scm

            stage 'Tests'
            node {
                sh './project_tests.sh'
            }
        }
        parallel stepsForParallel
    }
}
