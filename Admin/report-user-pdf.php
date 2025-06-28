<?php
require_once './dompdf/autoload.inc.php'; // Adjust path to your dompdf folder

use Dompdf\Dompdf;
use Dompdf\Options;

include_once "../db.php";

// Optional: Filters (status, date range)
$status = $_GET['status'] ?? 'all';
$from_date = $_GET['from_date'] ?? null;
$to_date = $_GET['to_date'] ?? null;

// Build SQL
$sql = "SELECT users.id, user_details.full_name AS name, email, status, users.created_at
        FROM users
        INNER JOIN user_details ON users.id = user_details.user_id WHERE 1=1";

if ($status !== 'all') {
    $sql .= " AND users.status = '" . $conn->real_escape_string($status) . "'";
}
if (!empty($from_date)) {
    $sql .= " AND DATE(users.created_at) >= '" . $conn->real_escape_string($from_date) . "'";
}
if (!empty($to_date)) {
    $sql .= " AND DATE(users.created_at) <= '" . $conn->real_escape_string($to_date) . "'";
}

$result = $conn->query($sql);

// Build HTML
$html = '<h2 style="text-align:center;">User Report</h2>';
$html .= '<table border="1" cellpadding="6" cellspacing="0" width="100%">
            <thead>
              <tr style="background:#f0f0f0;">
                <th>ID</th><th>Name</th><th>Email</th><th>Status</th><th>Registered Date</th>
              </tr>
            </thead><tbody>';
//print_r($result); // Debugging line to check the SQL query
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= '<tr>
                    <td>' . $row['id'] . '</td>
                    <td>' . htmlspecialchars($row['name'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($row['email'] ?? '-') . '</td>
                    <td>' . htmlspecialchars($row['status'] ?? '-') . '</td>
                    <td>' . date('Y-m-d', strtotime($row['created_at']) ?? '-') . '</td>
                  </tr>';
    }
} else {
    $html .= '<tr><td colspan="5">No users found.</td></tr>';
}
$html .= '</tbody></table>';

// Generate PDF
$options = new Options();
$options->set('isRemoteEnabled', true); // Allow loading fonts/images if needed
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("user-report.pdf", ["Attachment" => false]); // false = open in browser
exit;
