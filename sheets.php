<?php
session_start();
require 'config.php'; // Database configuration file

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch the search query
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query with optional search filter
    $sql = "SELECT ds.sheetid, ds.sheetname AS character_name, dst.sheettype AS sheet_type
            FROM dat_sheet ds
            JOIN dic_sheettype dst ON ds.sheettypekey = dst.sheettypekey
            WHERE ds.userid = :userid";
    if (!empty($search_query)) {
        $sql .= " AND ds.sheetname LIKE :search";
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':userid', $user_id, PDO::PARAM_INT);

    if (!empty($search_query)) {
        $stmt->bindValue(':search', '%' . $search_query . '%', PDO::PARAM_STR);
    }

    $stmt->execute();
    $sheets = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the error
    echo "Error: " . $e->getMessage();
    $sheets = []; // Default to empty array on error
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Sheets</title>
    <link rel="stylesheet" href="style.css"> <!-- Link to your external CSS file -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var modal = document.getElementById('createSheetModal');
            var openButton = document.getElementById('openSheetModal');
            var closeButton = modal.querySelector('.close');

            openButton.onclick = function () {
                modal.style.display = 'block';
            };

            closeButton.onclick = function () {
                modal.style.display = 'none';
            };

            window.onclick = function (event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            };
        });

        function deleteSheet(sheetId) {
            if (confirm('Are you sure you want to delete this sheet?')) {
                window.location.href = 'delete_sheet.php?sheetid=' + sheetId;
            }
        }
    </script>
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="sheets-container">
        <h2 class="sheets-title">My Sheets</h2>

        <a href="#" class="create-sheet-btn" id="openSheetModal">Create New Sheet</a>

        <!-- Search bar -->
        <form method="GET" action="" class="search-bar">
            <input type="text" name="search" placeholder="Search sheets..."
                value="<?php echo htmlspecialchars($search_query); ?>">
            <button class="search-button" type="submit">Search</button>
        </form>



        <div class="form-group">
            <div id="createSheetModal" class="sheets-modal modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Create New Sheet</h2>
                    <form id="createSheetForm" action="create_sheet.php" method="POST">
                        <label for="sheetName">Sheet Name:</label>
                        <input type="text" id="sheetName" name="sheetName" required>

                        <label for="sheetType">Sheet Type:</label>
                        <select id="sheetType" name="sheetType" required>
                            <option value="black_void">Black Void</option>
                        </select>

                        <button type="submit">Create Sheet</button>
                    </form>

                </div>
            </div>
        </div>

        <!-- Table for listing sheets -->
        <table class="sheets-table">
            <thead>
                <tr>
                    <th>Character Name</th>
                    <th>Sheet Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sheets)): ?>
                    <tr>
                        <td colspan="3">No sheets found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($sheets as $sheet): ?>
                        <tr>
                            <td>
                                <a href="sheets_blackvoid.php?sheetid=<?php echo htmlspecialchars($sheet['sheetid']); ?>">
                                    <?php echo htmlspecialchars($sheet['character_name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($sheet['sheet_type']); ?></td>
                            <td>
                                <a href="delete_sheet.php?sheetid=<?php echo htmlspecialchars($sheet['sheetid']); ?>"
                                    onclick="return confirm('Are you sure you want to delete this sheet?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>

</html>