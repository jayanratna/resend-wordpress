function resendCreateKey() {
    setTimeout(function () {
        resendCompleteKeyStep();
    }, 500);
}

function resendUseExistingKey() {
    setTimeout(function () {
        const enterKeyStep = document.querySelector(
            ".resend-setup-step-enter-key"
        );

        resendCompleteKeyStep();

        const enterKeyInput = enterKeyStep.querySelector(".resend-input");
        enterKeyInput.focus();
    }, 100);
}

function resendCompleteKeyStep() {
    const createKeyStep = document.querySelector(
        ".resend-setup-step-create-key"
    );
    const enterKeyStep = document.querySelector(".resend-setup-step-enter-key");

    const createKeyStepAction = createKeyStep.querySelector(
        ".resend-setup-steps-actions"
    );
    const enterKeyStepAction = enterKeyStep.querySelector(".resend-button");

    createKeyStep.classList.add("is-complete");
    createKeyStepAction.remove();

    enterKeyStep.classList.remove("is-disabled");
    enterKeyStepAction.classList.add("is-primary");
}
