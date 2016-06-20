elifePipeline {
    node("libraries") {
        stage 'Checkout'
        checkout scm

        stage 'Tests, lowest dependencies'
        sh 'dependencies=lowest ./project_tests.sh'

        stage 'Tests, default dependencies'
        sh 'dependencies=default ./project_tests.sh'
    }
}
