<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'dhuo_schedule');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function db(): mysqli {
  static $conn = null;
  if ($conn instanceof mysqli) return $conn;

  $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
  $conn->set_charset('utf8mb4');
  return $conn;
}

function _bind_params(mysqli_stmt $stmt, array $params): void {
  if (!$params) return;
  $types = str_repeat('s', count($params));
  $stmt->bind_param($types, ...$params);
}

function db_all(string $sql, array $params = []): array {
  $stmt = db()->prepare($sql);
  _bind_params($stmt, $params);
  $stmt->execute();
  $res = $stmt->get_result();
  return $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
}

function db_one(string $sql, array $params = []): ?array {
  $rows = db_all($sql, $params);
  return $rows[0] ?? null;
}

function db_exec(string $sql, array $params = []): int {
  $stmt = db()->prepare($sql);
  _bind_params($stmt, $params);
  $stmt->execute();
  return $stmt->affected_rows;
}

function go(string $to): never {
  header('Location: ' . $to);
  exit;
}

function required_fields(array $fields): void {
  foreach ($fields as $k => $v) {
    if (trim((string)$v) === '') {
      throw new Exception("Input '$k' wajib diisi.");
    }
  }
}
