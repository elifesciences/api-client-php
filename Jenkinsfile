elifeLibrary {
    stage 'Checkout'
    checkout scm

    elifeVariants(['lowest', 'default'], { dependencies ->
        elifeLocalTests "dependencies=${dependencies} ./project_tests.sh", ["build/${dependencies}-phpspec.xml", "build/${dependencies}-phpspec.xml"]
    })
}
