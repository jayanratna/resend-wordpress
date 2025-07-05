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

function resendTogglePassword(element, inputId) {
    const input = document.getElementById(inputId);
    console.log(element);

    const showIcon = element.querySelector("#show-password");
    const hideIcon = element.querySelector("#hide-password");

    if (input.type === "password") {
        input.type = "text";
        showIcon.style.display = "none";
        hideIcon.style.display = "inline-flex";
    } else {
        input.type = "password";
        showIcon.style.display = "inline-flex";
        hideIcon.style.display = "none";
    }
}
