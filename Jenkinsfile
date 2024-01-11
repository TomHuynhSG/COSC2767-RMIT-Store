pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                script {
                    git branch: 'main', url: 'https://github.com/KhangLeonardo/COSC2767-RMIT-Store.git'
                }
            }
        }

        stage('Transfer to Testing Server') {
            steps {
                script {
                    sshPublisher(
                        publishers: [
                            sshPublisherDesc(
                                configName: 'Testing Server',
                                transfers: [
                                    sshTransfer(
                                        cleanRemote: false,
                                        excludes: '',
                                        execCommand: '',
                                        execTimeout: 120000,
                                        flatten: false,
                                        makeEmptyDirs: false,
                                        noDefaultExcludes: false,
                                        patternSeparator: '[, ]+',
                                        remoteDirectory: '',
                                        remoteDirectorySDF: false,
                                        removePrefix: '',
                                        sourceFiles: '**/*'
                                    )
                                ],
                                usePromotionTimestamp: false,
                                useWorkspaceInPromotion: false,
                                verbose: false
                            )
                        ]
                    )
                }
            }
        }

        stage('Deploy to Testing Server') {
            steps {
                script {
                    sshagent(credentials: ['testing-server-ssh-key']) {
                        sh """
                            ssh -o StrictHostKeyChecking=no -tt ec2-user@44.195.41.174 << EOF
                            sudo su
                            sudo sh source-testing.sh
                            exit
                            exit
                        """
                    }
                }
            }
        }

        stage('Collect Test Results and Notify') {
            steps {
                script {
                    // 'Publish Over SSH' to copy the test-results.xml back to Jenkins server
                    sshPublisher(
                        publishers: [
                            sshPublisherDesc(
                                configName: 'Testing Server',
                                transfers: [
                                    sshTransfer(
                                        sourceFiles: '/home/ec2-user/log/test-results.xml',
                                        remoteDirectory: 'jenkins-collected-results/'
                                    )
                                ],
                                usePromotionTimestamp: false,
                                useWorkspaceInPromotion: false,
                                verbose: false
                            )
                        ]
                    )
                    
                    // Parse the test-results.xml file and check for failures
                    def testResults = readFile('jenkins-collected-results/test-results.xml')
                    def failures = sh(script: "echo '${testResults}' | grep -c 'failures=\"[1-9]' || true", returnStatus: true).trim()

                    // Send email notification if there are test failures
                    if (failures.toInteger() > 0) {
                        emailext subject: "Test Failures in Pipeline",
                                body: "There are test failures in the pipeline. Please check the results.",
                                to: "khangtgr@gmail.com",
                                mimeType: 'text/plain'
                    }
                }
            }
        }
    }
}
