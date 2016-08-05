elifeLibrary {
    stage 'Checkout'
    checkout scm

    elifeVariants(['lowest', 'default'], { dependencies ->
        sh "dependencies=${dependencies} ./project_tests.sh || echo TESTS FAILED"
        elifeTestArtifact "build/${dependencies}-phpspec.xml"
        elifeVerifyJunitXml "build/${dependencies}-phpspec.xml"
        elifeTestArtifact "build/${dependencies}-phpunit.xml"
        elifeVerifyJunitXml "build/${dependencies}-phpunit.xml"
    })
}
