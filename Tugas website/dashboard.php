<?php
include 'koneksi.php';

// Proses pencarian
$search_query = "";
$result = null;

if (isset($_GET['search'])) {
    $search_query = $conn->real_escape_string($_GET['search']);
    $sql = "SELECT * FROM pendaftar WHERE 
            name LIKE '%$search_query%' OR 
            email LIKE '%$search_query%' OR 
            phone LIKE '%$search_query%'";
    $result = $conn->query($sql);
} else {
    $sql = "SELECT * FROM pendaftar";
    $result = $conn->query($sql);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Peserta Lomba</title>
    <style>

{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family:  cursive;
}

body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(90deg, #7291d8, #c07375, #D84B57, #4782d0);
    background-size: 300% 300%;
    animation: gradientAnimation 10s ease infinite;
    margin: 0;
    padding: 0;
    color: #444;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 50vh;
}

@keyframes gradientAnimation {
    0% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        background-position: 0% 50%;
    }
}

header {
    width: 100%;
    padding: 20px;
    background: linear-gradient(90deg, #7291d8, #c07375, #D84B57, #4782d0);
    color: white;
    text-align: center;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    animation: gradientAnimation 10s ease infinite;
    }

    header h1 {
    font-family: 'Arial', sans-serif;
    font-size: 2.5rem;
    margin-bottom: 10px;
    }

  header nav ul {
    display: flex;
    justify-content: center;
    list-style: none;
    margin-top: 10px;
}

header nav ul li {
    margin: 0 15px;
}

header nav ul li a {
    color: white;
    font-size: 1rem;
    text-decoration: none;
    transition: color 0.3s;
}

header nav ul li a:hover {
    color: #D84B57;
}

h2 {
    position: relative;
    font-family: 'Arial', sans-serif;
    font-size: 3rem;
    text-align: center;
    color: #fff;
    font-weight: bold;
    margin: 20px auto 30px;
   
    padding: 10px 20px;
    background: linear-gradient(90deg, #5aa3bc, #4782d0);
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    animation: gradientAnimation 10s ease infinite;
}


h2:before {
    content: "";
    position: absolute;
    top: -5px;
    left: -5px;
    width: 100%;
    height: 100%;
    margin-top: -10px;
    border: 2px solid #fff;
    border-radius: 12px;
}

.header-actions {
    display: flex;
    justify-content: left;
    align-items: center;
    gap: 30px;
    margin: 30px 0;
    width: 80%;
    flex-wrap: wrap;
}

main {
    width: 90%;
    max-width: 1200px;
    margin-top: 20px;
}
.konten-utama {
  text-align: center;
  position: relative;
  
}

.search-container {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    align-items: center;
}

.search-container form {
    display: flex;
    gap: 10px;
}

.search-container input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 1rem;
    width: 250px;
}

.search-container button {
    padding: 10px 20px;
    background: linear-gradient(90deg, #c07375, #D84B57);
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.search-container button:hover {
    transform: translateY(-2px);
}

.search-container .btn {
    padding: 10px 20px;
    background: linear-gradient(90deg, #007bff, #3399ff);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 1rem;
    transition: transform 0.3s;
}

.search-container .btn:hover {
    transform: translateY(-2px);
}

.btn {
    display: inline-block;
    padding: 14px 28px;
    background: linear-gradient(90deg, #FF6F61, #D84B57);
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-size: 1.1em;
    box-shadow: 0 6px 14px rgba(0, 0, 0, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

table {
    width: 100%;
    margin: 40px auto;
    border-collapse: collapse;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    overflow: hidden;
    border-radius: 16px;
}

th, td {
    padding: 18px 22px;
    border: 1px solid #ddd;
    text-align: center;
}

th {
    background: linear-gradient(90deg, #FF6F61, #D84B57);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
}

td {
    background-color: #fff;
    transition: background-color 0.3s;
}

tr:nth-child(even) td {
    background-color: #f4f4f4;
}

tr:hover td {
    background-color: #f0f0f0;
}

.btn-edit, .btn-delete {
    padding: 12px 18px;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    display: inline-block;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn-edit {
    background: linear-gradient(90deg, #FFB74D, #FF9800);
}

.btn-edit:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 165, 0, 0.3);
}

.btn-delete {
    background: linear-gradient(90deg, #F44336, #FF5722);
}

.btn-delete:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(255, 67, 54, 0.3);
}

    </style>
</head>
<body>
    <header>
        <h1>Dashboard Peserta Lomba</h1>
        <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="form.php">Daftar Lomba</a></li>
                <li><a href="dashboard.php">Dashboard Peserta</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="dashboard">
            <div class="search-container">
                <form method="get" action="">
                    <input type="text" name="search" placeholder="Cari peserta..." value="<?php echo htmlspecialchars($search_query); ?>">
                    <button type="submit">Cari</button>
                </form>
                <a href="create.php" class="btn">Tambah Peserta Baru</a>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $counter++ . "</td>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                            echo "<td>
                                    <a href='update.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a>
                                    <a href='delete.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Apakah Anda yakin?\")'>Hapus</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data peserta</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

</body>
</html>