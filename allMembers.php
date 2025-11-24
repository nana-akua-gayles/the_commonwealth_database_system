<?php
session_start(); 

error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$password = "";
$db = "the_commonwealth_members";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch total records
$total_records_result = $conn->query("SELECT COUNT(*) AS total FROM registry");
if (!$total_records_result) {
    die("Query failed: " . $conn->error);
}
$total_records = $total_records_result->fetch_assoc()['total'];

// Pagination setup
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10; // Number of items per page
$total_pages = ceil($total_records / $items_per_page);

// Ensure current page is within valid bounds
$current_page = max(1, min($current_page, $total_pages));
$offset = ($current_page - 1) * $items_per_page;

// Fetch paginated data
$sql = "SELECT * FROM registry LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query was successful
if (!$result) {
    die("Query failed: " . $conn->error);
}

//Deleting data
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $itemId = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM registry WHERE id = ?");
    $stmt->bind_param("i", $itemId);

    if ($stmt->execute()) {
        http_response_code(204); // No content
    } else {
        // Log the error for debugging
        error_log("Delete Error: " . $stmt->error);
        http_response_code(500); // Internal server error
        echo json_encode(["error" => $stmt->error]);
    }
    $stmt->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Members - CC Global</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
</head>


<body>
                    <header class="adminHeader">
                            <img src="coloredLogo.PNG" class="aLogo" style="    width: 120px;
                        height: auto;">

                        <div class="dropdown">
                        <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user-tie icon" style="font-size: 17px; cursor: pointer"></i> Leadership</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Lead Presbyter</a></li>
                            <li><a class="dropdown-item" href="#">Pastors</a></li>
                            <li><a class="dropdown-item" href="#">Deacons & Deaconesses</a></li>
                        </ul>
                        </div>

                        <a class="oLink" href="#"><i class="fas fa-id-card-alt" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i> First Timers</a>
                        <a class="oLink" href="allMembers.php" style="background-color: #884f94ff; color: white; padding: 10px; border-radius: 5px;"><i class="fa fa-users" style="font-size: 16px; cursor: pointer; color: white;"></i> Members</a>
                        <a class="oLink" href="#"><i class="fas fa-user-shield" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i> Administrative Access</a>
                        
                        <div class="search-wrapper" style="position: relative; width: 180px;">
                        <input type="text" class="form-control" placeholder="Search..." aria-label="Search">
                        <i class="fas fa-search"></i>
                        </div>

                        <a class="oLink" href="#"><i class="fas fa-laptop-house" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i> Overview</a>
                        <a class="oLink" href="#"><i class="fas fa-cog" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i> Settings</a>
                        <a class="oLink" href="#"><i class="fas fa-question-circle" style="font-size: 18px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i> Help & Support</a>
                        <a class="oLink" href="#"><i class="far fa-bell" style="font-size: 22px; cursor: pointer; color: rgba(105, 99, 121, 1);"></i></a> 

                        <div class="profile">
                            <i class="fas fa-user-circle profile-icon" id="profileIcon" style="font-size: 35px;
                            cursor: pointer; color: rgba(105, 99, 121, 1);"></i>
                            
                            <div class="profile-card" id="profileCard">
                                <div class="usD">
                            <i class="fas fa-user-circle profile-icon" id="profileIcon" style="font-size: 50px;
                            color: rgba(105, 99, 121, 1); padding: 10px;"></i>            
                            <h6>ABIGAIL AKUA NINSIN</h6>
                                <h6 class="text-muted">General Administrator</h6>
                                <p>abigailakuaninsin@gmail.com</p>
                                <p>@queenie_gayles</hp>
                                <p>0596355972</p>
                                </div><br>
                                <div class="d-grid">
                                <button type="button" class="btn btn-primary btn-block" id="logoutBtn" 
                                style="background-color: #bf72ce; border: none;">Logout</button>
                                </div>

                            </div>
                        </div>
                    </header>

                   <p class="accH" style="padding: 15px; text-align: center; color: white; font-weight: bold; font-size: 1.4em;
                   background-color: #da3788; margin-bottom: 0;">REGISTERED MEMBERS - CHRIST COMMONWEALTH GLOBAL</p>

                    <div class= "bDiv">
                        <div class="row">
                            <div class="col-md-2" id="net" style="background-color: #d6d1d2c0; height: auto; overflow-y: auto;">
                                <p style="font-weight: bold; padding: 10px; font-size: 1.25em; margin-top: 10px; height: 40px;">NETWORKS</p>
                                <div class="networkB" style=" display: grid; width: 200px; padding: 15px; margin-top: 10px;">
                                    <b>ACCRA NETWORK</b>
                                    <a class="netLinks" href="#"><i class="fas fa-user-friends" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Leaders</a>
                                    <a class="netLinks"><i class="fas fa-dove" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Fellowships</a>
                                    <a class="netLinks"><i class="fas fa-rainbow" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> T-360s</a>
                                    <a class="netLinks"><i class="fas fa-praying-hands" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Stewards</a>
                                    <a class="netLinks" href=""><i class="fas fa-users" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Members</a>
                                </div>

                                <div class="networkB" style="display: grid; padding: 15px; margin-top: 10px;">
                                    <b>KUMASI NETWORK</b>
                                    <a class="netLinks" href="#"><i class="fas fa-user-friends" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Leaders</a>
                                    <a class="netLinks"><i class="fas fa-dove" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Fellowships</a>
                                    <a class="netLinks"><i class="fas fa-rainbow" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> T-360s</a>
                                    <a class="netLinks"><i class="fas fa-praying-hands" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Stewards</a>
                                    <a class="netLinks" href=""><i class="fas fa-users" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Members</a>
                                </div>

                                <div class="networkB" style="display: grid; padding: 15px; margin-top: 10px; margin-bottom: 10px; text-align: left">
                                    <b>HO NETWORK</b>
                                    <a class="netLinks" href="#"><i class="fas fa-user-friends" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Leaders</a>
                                    <a class="netLinks"><i class="fas fa-dove" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Fellowships</a>
                                    <a class="netLinks"><i class="fas fa-rainbow" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> T-360s</a>
                                    <a class="netLinks"><i class="fas fa-praying-hands" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Stewards</a>
                                    <a class="netLinks" href=""><i class="fas fa-users" style="font-size: 16px; cursor: pointer; color: rgba(105, 99, 121, 1); margin-right: 3px;"></i> Members</a>
                                </div>    
                                
                            </div>
                
           
                    <div class="col-md-8"> 
                    <div class="d-flex align-items-center mb-3" style="background-color: #d6d1d2c0; width: 100%; height:50px;
                    text-align: center; justify-items: center; box-shadow: 7px 5px 5px #615f61c0;">
                        <div class="form-check me-3">
                            <input type="checkbox" class="form-check-input" id="showAll" onclick="toggleShowAll()" style="margin-left: 10px; margin-top: 10px">
                            <label class="form-check-label" for="showAll" style="padding-left: 5px;">Show all</label>
                            <span style="text-align: center; font-size: 1.4em; margin-left: 5px">|</span>
                        </div>
                        <div class="me-3 d-flex align-items-center">
                            <label for="rowCount" class="form-label me-2" style="margin-top: 10px;">Number of rows:</label>
                            <select id="rowCount" class="form-select" onchange="updateRowCount()" style="width: 70px; border-radius: 0; height: 35px;">
                                <option value="10" selected>10</option>
                                <option value="25">15</option>
                                <option value="50">20</option>
                                <option value="100">25</option>
                            </select>
                        </div>
                        <div class="me-3 d-flex align-items-center">
                            <label for="filterInput" class="form-label me-2" style="margin-top: 10px;">Filter rows:</label>
                            <input type="text" id="filterInput" class="form-control" placeholder="Search this table" oninput="filterTable()" 
                            style="width: 200px; border-radius: 0; height: 35px;">
                        </div>
                        <div class="d-flex align-items-center">
                            <label for="sortBy" class="form-label me-2" style="margin-top: 10px;">Sort by key:</label>
                            <select id="sortBy" class="form-select" onchange="sortTable()" style="width: 120px; border-radius: 0; height: 35px;">
                                <option value="id-asc">ID (ASC)</option>
                                <option value="id-desc">ID (DESC)</option>
                            </select>
                        </div>
                    </div>
                        <a href="membershipform.php"  style="display: block; width: 180px; text-decoration: none; background-color: #884f94ff; color: white;
                        border-radius: 10px; padding: 17px; margin-top: 20px;">Add a New Member</a><br>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-success">
                                <tr>
                                    <th>Id</th>
                                    <th>Picture</th>
                                    <th>Title</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>Date of Birth</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Marital Status</th>
                                    <th>Nationality</th>
                                    <th>Education</th>
                                    <th>Profession</th>
                                    <th>Next of Kin</th>
                                    <th>Next of Kin's Contact</th>
                                    <th>Network</th>
                                    <th>Fellowship</th>
                                    <th>T360s</th>
                                    <th>Function</th>
                                    <th>Stewardship Groups</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table-body">
                        <?php
                            if ($result->num_rows > 0) {
                                $counter = 1; 
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . $counter . "</td>
                                            <td><img src='" . htmlspecialchars($row['picture']) . "' alt='Passport Photo' style='max-width: 100px;'></td>
                                            <td>" . htmlspecialchars($row['title']) . "</td>
                                            <td>" . htmlspecialchars($row['fullName']) . "</td>
                                            <td>" . htmlspecialchars($row['gender']) . "</td>
                                            <td>" . htmlspecialchars($row['dob']) . "</td>
                                            <td>" . htmlspecialchars($row['number']) . "</td>
                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                            <td>" . htmlspecialchars($row['address']) . "</td>
                                            <td>" . htmlspecialchars($row['maritalStatus']) . "</td>
                                            <td>" . htmlspecialchars($row['nationality']) . "</td>
                                            <td>" . htmlspecialchars($row['education']) . "</td>
                                            <td>" . htmlspecialchars($row['profession']) . "</td>
                                            <td>" . htmlspecialchars($row['emergencyContactName']) . "</td>
                                            <td>" . htmlspecialchars($row['emergencyContact']) . "</td>
                                            <td>" . htmlspecialchars($row['network']) . "</td>
                                            <td>" . htmlspecialchars($row['fellowship']) . "</td>
                                            <td>" . htmlspecialchars($row['t360s']) . "</td>
                                            <td>" . htmlspecialchars($row['function']) . "</td>
                                            <td>" . htmlspecialchars($row['stewardshipGroups']) . "</td>
                                            <td><a href='edit.php?id=" . urlencode($row['id']) . "' class='action-icons text-success' title='Edit'>
                                                    <i class='fas fa-edit'></i></a>
                                                <a class='action-icons text-danger delete-btn' data-id='" . htmlspecialchars($row['id']) . "' title='Delete'>
                                                    <i class='fas fa-trash-alt'></i></a>
                                            </td>
                                        </tr>";
                                        $counter++; 
                                }
                            } else {
                                echo "<tr><td colspan='20'>No submissions found.</td></tr>";
                            }
                                    ?>
                            </tbody>
                        </table>
                        <div class="overlay"></div>
                        <div class="custom-confirm">
                            <h4>Confirm Delete</h4>
                            <p>Are you really sure you want to delete this entry?</p>
                            <button id="confirmDelete" class="btn btn-danger">Yes, Delete</button>
                            <button id="cancelDelete" class="btn btn-secondary">Cancel</button>
                        </div></div>
                    <div class="d-flex justify-content-center mt-3">
                        <nav aria-label="Page navigation">
            <ul class="pagination" id="pagination">
                <?php if ($current_page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page - 1; ?>&filter=<?php echo urlencode($filter); ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">&laquo;</span>
                    </li>
                <?php endif; ?>

                <?php 
                $pagination_range = 2; // How many pages to show before/after the current page
                for ($page = 1; $page <= $total_pages; $page++): 
                    if ($page < $current_page - $pagination_range || $page > $current_page + $pagination_range) {
                        if ($page == 1 || $page == $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page='. $page .'&filter='. urlencode($filter) .'">'. $page .'</a></li>';
                        } else if ($page == 2 || $page == $total_pages - 1) {
                            echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        continue;
                    }
                ?>
                    <li class="page-item <?php echo ($page == $current_page) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $page; ?>&filter=<?php echo urlencode($filter); ?>"><?php echo $page; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $current_page + 1; ?>&filter=<?php echo urlencode($filter); ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="page-item disabled">
                        <span class="page-link" aria-hidden="true">&raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
                </div> 
            </div>

                <div class="col-md-2">
                <h5>Notifications</h5>
                <div class="notification">
                    <p>This is a notification message!</p>
                </div>
            </div></div>
 
 
        </div>
 
  
    </div>
<script src="bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('profileIcon').onclick = function() {
    var card = document.getElementById('profileCard');
    card.style.display = card.style.display === 'none' || card.style.display === '' ? 'block' : 'none';
};

// Close the card when clicking outside of it
window.onclick = function(event) {
    if (!event.target.matches('#profileIcon') && !event.target.matches('#editProfileBtn')) {
        var card = document.getElementById('profileCard');
        card.style.display = 'none';
    }
};
    // The code for logging out
    document.getElementById('logoutBtn').onclick = function() {

// Redirecting to the login Form
    window.location.href = 'logout.php'; 
};

// Initialize variables
let currentData = [];
let currentPage = 1;
let rowsPerPage = 10;

// Load data on DOM content load
document.addEventListener("DOMContentLoaded", function() {
    const rows = document.querySelectorAll("#table-body tr");
    rows.forEach(row => {
        const cells = row.querySelectorAll("td");
        if (cells.length > 0) {
            const imgElement = cells[1].querySelector('img'); 
            const imgSrc = imgElement ? imgElement.src : '';
            currentData.push({
                id: parseInt(cells[0].innerText),
                picture: imgSrc,
                title: cells[2].innerText,
                fullName: cells[3].innerText,
                gender: cells[4].innerText,
                dob: cells[5].innerText,
                number: cells[6].innerText,
                email: cells[7].innerText,
                address: cells[8].innerText,
                maritalStatus: cells[9].innerText,
                nationality: cells[10].innerText,
                education: cells[11].innerText,
                profession: cells[12].innerText,
                nextOfKin: cells[13].innerText,
                nextOfKinContact: cells[14].innerText,
                network: cells[15].innerText,
                fellowship: cells[16].innerText,
                t360s: cells[17].innerText,
                function: cells[18].innerText,
                stewardshipGroups: cells[19].innerText
            });
        }
    });
    updateRowCount();
});

// Update number of rows displayed
function updateRowCount() {
    rowsPerPage = parseInt(document.getElementById('rowCount').value);
    currentPage = 1; // Reset to first page
    renderTable(currentData);
    renderPagination();
}

// Filter table data based on user input
function filterTable() {
    const filterValue = document.getElementById('filterInput').value.toLowerCase();
    const filteredData = currentData.filter(item => 
        [item.title, item.fullName, item.email, item.address, item.gender,
        item.maritalStatus, item.nationality, item.education,
        item.profession, item.network, item.fellowship,
        item.t360s, item.function, item.stewardshipGroups]
        .some(attr => attr.toLowerCase().includes(filterValue))
    );

    currentPage = 1; // Reset to first page when filtering
    renderTable(filteredData);
    renderPagination(filteredData);
}

// Sort the table data
function sortTable() {
    const sortBy = document.getElementById('sortBy').value;
    let sortedData;

    if (sortBy === 'id-asc') {
        sortedData = [...currentData].sort((a, b) => a.id - b.id);
    } else if (sortBy === 'id-desc') {
        sortedData = [...currentData].sort((a, b) => b.id - a.id);
    }

    currentPage = 1; // Reset to first page
    renderTable(sortedData);
    renderPagination(sortedData);
}

// Render table with paginated data
function renderTable(data) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedData = data.slice(start, end);

    paginatedData.forEach(item => {
        const row = `<tr>
            <td>${item.id}</td>
            <td><img src='${item.picture}' alt='Picture' style='max-width: 70px;'></td>
            <td>${item.title}</td>
            <td>${item.fullName}</td>
            <td>${item.gender}</td>
            <td>${item.dob}</td>
            <td>${item.number}</td>
            <td>${item.email}</td>
            <td>${item.address}</td>
            <td>${item.maritalStatus}</td>
            <td>${item.nationality}</td>
            <td>${item.education}</td>
            <td>${item.profession}</td>
            <td>${item.nextOfKin}</td>
            <td>${item.nextOfKinContact}</td>
            <td>${item.network}</td>
            <td>${item.fellowship}</td>
            <td>${item.t360s}</td>
            <td>${item.function}</td>
            <td>${item.stewardshipGroups}</td>
            <td>
                <a href='edit.php?id=${item.id}' class='action-icons text-success' title='Edit'><i class='fas fa-edit'></i></a>
                <a href='#' class='action-icons text-danger delete-btn' data-id='${item.id}' title='Delete'><i class='fas fa-trash-alt'></i></a>
            </td>
        </tr>`;
        tableBody.innerHTML += row;
    });
}

// Render pagination
function renderPagination(data = currentData) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    const totalPages = Math.ceil(data.length / rowsPerPage);

    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
        pageItem.innerHTML = `<a class='page-link' href='#' onclick='changePage(${i})'>${i}</a>`;
        pagination.appendChild(pageItem);
    }
}

function changePage(page) {
    currentPage = page;                 
    renderTable(currentData);           
    renderPagination(currentData);       
}

unction renderPagination(data = currentData) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = '';
    const totalPages = Math.ceil(data.length / rowsPerPage);
    // Previous button
    const prevButton = document.createElement('li');
    prevButton.className = 'page-item' + (currentPage === 1 ? ' disabled' : '');
    prevButton.innerHTML = `<a class='page-link' href='#' onclick='changePage(${currentPage - 1})'>Previous</a>`;
    pagination.appendChild(prevButton);

    for (let i = 1; i <= totalPages; i++) {
        const pageItem = document.createElement('li');
        pageItem.className = 'page-item' + (i === currentPage ? ' active' : '');
        pageItem.innerHTML = `<a class='page-link' href='#' onclick='changePage(${i})'>${i}</a>`;
        pagination.appendChild(pageItem);
    }
    // Next button
    const nextButton = document.createElement('li');
    nextButton.className = 'page-item' + (currentPage === totalPages ? ' disabled' : '');
    nextButton.innerHTML = `<a class='page-link' href='#' onclick='changePage(${currentPage + 1})'>Next</a>`;
    pagination.appendChild(nextButton);  
    }

document.addEventListener("DOMContentLoaded", function() {
    // Populate currentData as before...
    renderTable(currentData);
    renderPagination(currentData);
    // Add event listeners to inputs for filtering/sorting if applicable
});

//Data Deletion

let currentItemId = null;

document.addEventListener('click', function (e) {
    const deleteBtn = e.target.closest('.delete-btn');
    if (deleteBtn) {
        currentItemId = deleteBtn.getAttribute('data-id');
        console.log(`Delete button clicked. Current Item ID: ${currentItemId}`);
        document.querySelector('.overlay').style.display = 'block';
        document.querySelector('.custom-confirm').style.display = 'block';
    }
});

// Ensure cancel button works
document.getElementById('cancelDelete').addEventListener('click', function () {
    document.querySelector('.overlay').style.display = 'none';
    document.querySelector('.custom-confirm').style.display = 'none';
});

// Confirm deletion logic
document.getElementById('confirmDelete').addEventListener('click', function () {
    if (!currentItemId) {
        console.error("No currentItemId set for deletion.");
        return; // Exit if currentItemId is null
    }

    console.log(`Deleting item with ID: ${currentItemId}`);
    fetch(`allMembers.php?action=delete&id=${currentItemId}`, { // Ensure the URL is correct
        method: 'DELETE'
    })
    .then(response => {
        console.log("Response:", response);
        if (response.ok) {
            const buttonToRemove = document.querySelector(`.delete-btn[data-id="${currentItemId}"]`);
            const rowToRemove = buttonToRemove.closest('tr');
            if (rowToRemove) {
                console.log("Removing row:", rowToRemove);
                rowToRemove.remove();
            }
        } else {
            alert('Error deleting item: ' + response.statusText);
        }

        // Hide confirmation modal regardless of outcome
        document.querySelector('.overlay').style.display = 'none';
        document.querySelector('.custom-confirm').style.display = 'none';
    })
    .catch(err => {
        console.error('Error:', err);
        alert('Error deleting item.');
        document.querySelector('.overlay').style.display = 'none';
        document.querySelector('.custom-confirm').style.display = 'none';
    });
});
</script>   
</body>
</html>
<?php
$conn->close(); 
?>            