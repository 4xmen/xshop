function startCountdown(unixTimestamp) {

    function updateCountdown() {
        const now = Math.floor(Date.now() / 1000); // Current time in seconds
        const remainingTime = unixTimestamp - now;

        if (remainingTime <= 0) {
            countdownElement.innerHTML = "Time's up!";
            clearInterval(interval);
        } else {
            const seconds = remainingTime % 60;
            const minutes = Math.floor((remainingTime / 60) % 60);
            const hours = Math.floor((remainingTime / 3600) % 24);
            const days = Math.floor(remainingTime / 86400);

            document.querySelector('#dcd').innerText = numFixer(days);
            document.querySelector('#hcd').innerText = numFixer(hours);
            document.querySelector('#mcd').innerText = numFixer(minutes);
            document.querySelector('#scd').innerText = numFixer(seconds);
        }
    }

    updateCountdown(); // Initial call to display immediately
    const interval = setInterval(updateCountdown, 1000);
}

function numFixer(x) {
    if (x < 10) {
        return '0' + x;
    }
    return x.toString();
}

window.addEventListener('load', function () {
    if  (document.querySelector('#count-down-time-timestamp') != null){
    startCountdown(parseInt(document.querySelector('#count-down-time-timestamp').value));
    }
});
