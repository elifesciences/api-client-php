elifePipeline {
    node("libraries") {
        stage 'Checkout'
        git url: 'git@github.com:giorgiosironi/api-sdk-php.git'

        stage 'Tests'
        sh './project_tests.sh'
    }
}
