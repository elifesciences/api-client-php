elifePipeline {
    node("libraries") {
        stage 'Checkout'
        checkout scm

        stage 'Tests, lowest dependencies'
        sh 'dependencies=lowest ./project_tests.sh || echo TESTS FAILED'
        elifeVerifyJunitXml 'build/lowest-phpspec.xml'
        elifeVerifyJunitXml 'build/lowest-phpunit.xml'

        stage 'Tests, default dependencies'
        sh 'dependencies=default ./project_tests.sh || echo TESTS FAILED'
        elifeVerifyJunitXml 'build/default-phpspec.xml'
        elifeVerifyJunitXml 'build/default-phpunit.xml'
    }
}
