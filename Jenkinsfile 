def agentLabel
if (BRANCH_NAME == "main") {
    agentLabel = "vds"
} else {
    agentLabel = "coloc"
}

node("${agentLabel}") {
    def scmVars = checkout scm
    def GIT_COMMIT="${scmVars.GIT_COMMIT}"
    def SHORT_COMMIT = "${GIT_COMMIT[0..9]}"
    def GIT_COMMIT_MSG = sh (script: 'git log -1 --pretty=%B ${GIT_COMMIT}', returnStdout: true).trim()
    def GIT_AUTHOR = sh (script: 'git log -1 --pretty=%cn ${GIT_COMMIT}', returnStdout: true).trim()
    def JOB_NAME = JOB_NAME.toLowerCase()
    def GIT_REPO_NAME = "${scmVars.GIT_URL}".replaceFirst(/^.*\/([^\/]+?).git$/, '$1').toLowerCase()
    def SWARM_WEBHOOK = 'http://swarm.irkpk.test/api/stacks/webhooks/1339ee80-ae94-45d5-b269-f5ad41ef9f31'
    def SWARM_WEBHOOK_DEV = 'http://swarm.irkpk.test/api/stacks/webhooks/1339ee80-ae94-45d5-b269-f5ad41ef9f31'
    sh 'mkdir -p builder'
    dir("builder") {
        script {
            git branch: "main",
                credentialsId: 'b608ce96-7761-4027-bc50-be2c8d96b79d',
                url: 'https://git.irkpk.ru/ipc/jenkinsfile_libs'
        }
    }
    withEnv([
        "SHORT_COMMIT=${SHORT_COMMIT}",
        "JOB_NAME=${JOB_NAME}",
        "GIT_AUTHOR=${GIT_AUTHOR}",
        "GIT_COMMIT_MSG=${GIT_COMMIT_MSG}",
        "GIT_REPO_NAME=${GIT_REPO_NAME}",
        "SWARM_WEBHOOK=${SWARM_WEBHOOK}",
        "SWARM_WEBHOOK_DEV=${SWARM_WEBHOOK_DEV}"
    ]) {
        load 'builder/Jenkinsfile_Extended'
    }
}