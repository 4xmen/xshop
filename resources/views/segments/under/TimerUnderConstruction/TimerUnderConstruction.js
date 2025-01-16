function startCountdownUnder(unixTimestamp) {

    function updateCountdown() {
        const now = Math.floor(Date.now() / 1000); // Current time in seconds
        const remainingTime = unixTimestamp - now;

        if (remainingTime <= 0) {
            clearInterval(interval);
        } else {
            const seconds = remainingTime % 60;
            const minutes = Math.floor((remainingTime / 60) % 60);
            const hours = Math.floor((remainingTime / 3600) % 24);
            const days = Math.floor(remainingTime / 86400);

            document.querySelector('#udcd').innerText = numFixer(days);
            document.querySelector('#uhcd').innerText = numFixer(hours);
            document.querySelector('#umcd').innerText = numFixer(minutes);
            document.querySelector('#uscd').innerText = numFixer(seconds);
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
    if  (document.querySelector('#under-count-down-time-timestamp') != null){
        startCountdownUnder(parseInt(document.querySelector('#under-count-down-time-timestamp').value));
    }
});
