function resendCreateKey() {
    const createKeyStep = document.querySelector(
        ".resend-setup-step-create-key"
    );
    const enterKeyStep = document.querySelector(".resend-setup-step-enter-key");

    const createKeyStepAction = createKeyStep.querySelector(".resend-button");
    const enterKeyStepAction = enterKeyStep.querySelector(".resend-button");

    setTimeout(function () {
        createKeyStep.classList.add("is-complete");
        createKeyStepAction.remove();

        enterKeyStep.classList.remove("is-disabled");
        enterKeyStepAction.classList.add("is-primary");
    }, 500);
}
