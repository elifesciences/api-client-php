elifePipeline {
    node("libraries") {
        stage 'Checkout'
        checkout scm

        stage 'Tests'
        sh './project_tests.sh'
    }
}
