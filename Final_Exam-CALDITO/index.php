<?php
include 'includes/db.php';

// Which section to show on page load (from redirect after form submit)
$activeSection = isset($_GET['section']) ? htmlspecialchars($_GET['section']) : 'home';

// For Update: search by ID (use strict null check so ID=0 doesn't break)
$searchId     = (isset($_GET['search_id']) && $_GET['search_id'] !== '') ? (int)$_GET['search_id'] : null;
$searchResult = null;

if ($searchId !== null) {
    $res = mysqli_query($conn, "SELECT * FROM students WHERE id=" . $searchId);
    if ($res) $searchResult = mysqli_fetch_assoc($res);
}

// Fetch all students for Read section
$allStudents = mysqli_query($conn, "SELECT * FROM students ORDER BY id ASC");
$studentCount = $allStudents ? mysqli_num_rows($allStudents) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CALDITO - Student Management System</title>
    <meta name="description" content="CALDITO Student Management System — A CRUD application for Integrative Programming Technologies.">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <img src="logo1.png" id="logo" onclick="hideSections()" title="Go to Home" alt="logo1">
        <button class="navbarbuttons" id="btn-create" onclick="showSection('create')"> Create </button>
        <button class="navbarbuttons" id="btn-read"   onclick="showSection('read')">   Read   </button>
        <button class="navbarbuttons" id="btn-update" onclick="showSection('update')"> Update </button>
        <button class="navbarbuttons" id="btn-delete" onclick="showSection('delete')"> Delete </button>
    </nav>

    <!-- HOME SECTION -->
    <section id="home" class="homecontent">
        <h1 class="splash">Welcome to Student Management System</h1>
        <h2 class="splash">A Project in Integrative Programming Technologies</h2>
    </section>

    <!-- CREATE SECTION -->
    <section id="create" class="content">
        <h1 class="contenttitle">Insert New Student</h1>

        <form action="includes/insert.php" method="POST">
            <label for="surname" class="label">Surname</label>
            <input type="text" name="surname" id="surname" class="field" required><br/>

            <label for="name" class="label">Name</label>
            <input type="text" name="name" id="name" class="field" required><br/>

            <label for="middlename" class="label">Middle Name</label>
            <input type="text" name="middlename" id="middlename" class="field"><br/>

            <label for="address" class="label">Address</label>
            <input type="text" name="address" id="address" class="field"><br/>

            <label for="contact" class="label">Mobile Number</label>
            <input type="text" name="contact" id="contact" class="field"><br/>

            <div class="btncontainer">
                <button type="button" id="clrbtn" class="btns">Clear Fields</button>
                <button type="submit" id="savebtn" class="btns">Save</button>
            </div>
        </form>
    </section>

    <!-- READ SECTION -->
    <section id="read" class="content">
        <h1 class="contenttitle">View Students</h1>

        <div class="table-wrapper">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Surname</th>
                        <th>Name</th>
                        <th>Middle Name</th>
                        <th>Address</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($studentCount > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($allStudents)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo htmlspecialchars($row['surname']); ?></td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['middlename']); ?></td>
                            <td><?php echo htmlspecialchars($row['address']); ?></td>
                            <td><?php echo htmlspecialchars($row['contact_number']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="no-records">No student records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- UPDATE SECTION -->
    <section id="update" class="content">
        <h1 class="contenttitle">Update Student Records</h1>

        <!-- Step 1: Search by ID -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET">
            <input type="hidden" name="section" value="update">
            <label for="search_id" class="label">Student ID</label>
            <input type="number" name="search_id" id="search_id" class="field"
                   placeholder="Enter student ID" value="<?php echo htmlspecialchars($searchId ?? ''); ?>"><br/>
            <div class="btncontainer">
                <button type="submit" class="btns">Find Student</button>
            </div>
        </form>

        <?php if ($searchId !== null && $searchResult): ?>
        <!-- Step 2: Edit Form (pre-filled) -->
        <hr class="section-divider">
        <form action="includes/update.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $searchResult['id']; ?>">

            <label for="upd_surname" class="label">Surname</label>
            <input type="text" name="surname" id="upd_surname" class="field"
                   value="<?php echo htmlspecialchars($searchResult['surname']); ?>" required><br/>

            <label for="upd_name" class="label">Name</label>
            <input type="text" name="name" id="upd_name" class="field"
                   value="<?php echo htmlspecialchars($searchResult['name']); ?>" required><br/>

            <label for="upd_middlename" class="label">Middle Name</label>
            <input type="text" name="middlename" id="upd_middlename" class="field"
                   value="<?php echo htmlspecialchars($searchResult['middlename']); ?>"><br/>

            <label for="upd_address" class="label">Address</label>
            <input type="text" name="address" id="upd_address" class="field"
                   value="<?php echo htmlspecialchars($searchResult['address']); ?>"><br/>

            <label for="upd_contact" class="label">Mobile Number</label>
            <input type="text" name="contact" id="upd_contact" class="field"
                   value="<?php echo htmlspecialchars($searchResult['contact_number']); ?>"><br/>

            <div class="btncontainer">
                <button type="submit" class="btns btn-update">Update Student</button>
            </div>
        </form>

        <?php elseif ($searchId !== null && !$searchResult): ?>
        <p class="not-found-msg">No student found with ID <strong><?php echo $searchId; ?></strong>.</p>
        <?php endif; ?>

    </section>

    <!-- DELETE SECTION -->
    <section id="delete" class="content">
        <h1 class="contenttitle">Remove Student Records</h1>

        <form action="includes/delete.php" method="POST"
              onsubmit="return confirm('Are you sure you want to delete student ID ' + document.getElementById('del_id').value + '? This cannot be undone.')">
            <label for="del_id" class="label">Student ID</label>
            <input type="number" name="id" id="del_id" class="field"
                   placeholder="Enter student ID to delete" required><br/>
            <div class="btncontainer">
                <button type="submit" class="btns btn-delete">Delete Student</button>
            </div>
        </form>
    </section>

    <!-- Global Toast Notification -->
    <div id="global-toast" class="toast-hidden"></div>

    <script src="script.js"></script>
    <script>
        // Auto-show the correct section when redirected back from PHP includes
        // Runs after script.js is loaded; DOMContentLoaded already fired so call directly
        (function() {
            var section = '<?php echo $activeSection; ?>';
            if (section && section !== 'home') {
                showSection(section);
            }
        })();
    </script>

</body>
</html>