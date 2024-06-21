document.addEventListener('DOMContentLoaded', function() {
    const steps = document.querySelectorAll('.steps li');
    const stepsContainer = document.querySelector('.steps');
    const stepTabs = document.querySelectorAll('#step-tabs > div');
    const nextButtons = document.querySelectorAll('.step-next');
    const prevButtons = document.querySelectorAll('.step-prev');
    let currentStep = 0;

    function updateProgress(stepIndex) {
        const progress = (stepIndex + 1) / steps.length * 100;
        stepsContainer?.style.setProperty('--progress', `${progress}%`);
    }

    function showStep(stepIndex) {
        steps.forEach((step, index) => {
            step.classList.toggle('active', index <= stepIndex);
        });

        stepTabs.forEach((tab, index) => {
            if (index === stepIndex) {
                tab.classList.add('active');
                setTimeout(() => tab.style.opacity = 1, 0);
            } else {
                tab.style.opacity = 0;
                setTimeout(() => tab.classList.remove('active'), 0);
            }
        });

        updateProgress(stepIndex);
        currentStep = stepIndex;
    }

    function nextStep() {
        if (currentStep < steps.length - 1) {
            showStep(currentStep + 1);
        }
    }

    function prevStep() {
        if (currentStep > 0) {
            showStep(currentStep - 1);
        }
    }

    steps.forEach((step, index) => {
        step.addEventListener('click', () => showStep(index));
    });

    nextButtons.forEach(button => {
        button.addEventListener('click', nextStep);
    });

    prevButtons.forEach(button => {
        button.addEventListener('click', prevStep);
    });

    // Show the first step initially
    showStep(0);
});
