

    <footer class="footer footer-copyright">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-12 text-center">
                    <x-copyright/>
                </div>
                <div class="col-6 text-end">
                    <ul class="list-inline">
                        
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</div>
</div>


<!--  Updated jQuery to latest stable (v3.7.1) -->

<!-- 
----------------------- No need because of bundle.min.js already
--------------------------------------------------------------------
---------------------
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>  
----------------
----------------->
<!-- Local Scripts -->
<!-- <script src="{{asset('admin/js/app.js')}}"></script> -->

<!--  Updated Bootstrap Bundle JS (v5.3.3) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>




<script>
	// Automatically logout user after 5 minutes of inactivity
var inactivityTime = function () {
    var time;
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer; // captures touch events on mobile
    window.ontouchstart = resetTimer;
    window.onclick = resetTimer;
    window.onkeypress = resetTimer;

    function logoutAndReload() {
        // Logout the user
        window.location.href = "{{ route('logout') }}"; // Adjust to your actual logout route

        // After logging out, reload the page
        window.location.reload();
    }

    function resetTimer() {
        clearTimeout(time);
        // Set timeout to log out and reload after 5 minutes of inactivity
        time = setTimeout(logoutAndReload, 300000);  // 5 minutes (300000 ms)
    }
};

inactivityTime();
</script>



	@yield('scripts')

</body>

</html>