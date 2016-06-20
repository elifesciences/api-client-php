elifePipeline {
    node("libraries") {
        stage 'Checkout'
        checkout scm

        stage 'Tests, lowest'
        sh 'dependencies=lowest ./project_tests.sh'

        stage 'Tests, normal'
        sh './project_tests.sh'
    }
}
