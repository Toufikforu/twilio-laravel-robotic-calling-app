let lastStatus = window.appData.lastStatus;

setInterval(() => {
    fetch(window.appData.checkStatusUrl)
        .then((res) => res.json())
        .then((data) => {
            const currentStatus = data.approved ? "approved" : "pending";
            if (currentStatus !== lastStatus) {
                location.reload();
            }
        })
        .catch(console.error);
}, 5000);
