<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Get current page filename
?>

    <nav id="nav-1">
        <ul id="nav-2">
            <li>
                <a class="nav-a <?php if($currentPage == 'create_topic.php') echo 'active'; ?>" href="create_topic.php">Create topic</a>
            </li>
            <li>
                <a class="nav-a <?php if($currentPage == 'dashboard.php') echo 'active'; ?>" href="dashboard.php">Login/Logout</a>
            </li>
            <li>
                <a class="nav-a <?php if($currentPage == 'profile.php') echo 'active'; ?>" href="profile.php">Profile</a>
            </li>
            <li>
                <a class="nav-a <?php if($currentPage == 'vote.php') echo 'active'; ?>" href="vote.php">Vote Topic</a>
            </li>
            <li>
                <a class="nav-a" href="#" id="theme-toggle">Change theme color</a>
            </li>
        </ul>
    </nav>


    <script>
    const toggle = document.getElementById("theme-toggle");

    // On page load, check stored theme
    if (localStorage.getItem("theme") === "light") {
        document.body.classList.add("light-theme");
    }

    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.toggle("light-theme");

        // Save current theme
        if (document.body.classList.contains("light-theme")) {
            localStorage.setItem("theme", "light");
        } else {
            localStorage.setItem("theme", "dark");
        }
    });
</script>

<style>
    #nav-1 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 60px; /* ← Set a fixed height */
        background-color: #333;
        display: flex;
        align-items: center; /* vertically center links */
        z-index: 1000;
    }

    #nav-2 {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0 1rem;
        gap: 1rem;
    }

    .nav-a {

        display: block;
        padding: 14px 16px;
        color: white;
        text-decoration: none;
    }

    body {
        margin: 0;
        padding-top: 60px; /* MUST match nav height */
        background-color: var(--bg);
        color: var(--text);
    }


    nav a:hover {
        background-color: #111;
    }

    body {

        /*light theme stuff*/
        background-color: var(--bg);
        color: var(--text);
        transition: background-color 0.3s ease;
        /*light theme stuff*/

        /* Removed height: 100vh; */
        /* Removed display: flex; */

    }
    :root {
        --bg: #000000;
        --text: #ffffff;
    }

    /* Light Theme */
    body.light-theme {
        --bg: #ffffff;
        --text: #000000;
    }
    .nav-a.active {
        color: #fff; /* text color */
        background-color: #007bff; /* highlight background */
        font-weight: bold;
        border-radius: 4px; /* optional rounded corners */
    }

</style>

<?php
    $currentPage = basename($_SERVER['PHP_SELF']); // e.g., "dashboard.php"
?>


<?php /*show_source() */?>