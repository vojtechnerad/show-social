</div>
<script type="text/javascript" src="../scripts/bootstrap.bundle.min.js"></script>
<script>
    if (!navigator.serviceWorker.controller) {
        navigator.serviceWorker.register("/sw.js").then(function(reg) {
            console.log("Service worker has been registered for scope: " + reg.scope);
        });
    }

    const myModal = document.getElementById('myModal');
    const myInput = document.getElementById('myInput');

    myModal.addEventListener('shown.bs.modal', () => {
        myInput.focus()
    });
</script>
</body>
</html>