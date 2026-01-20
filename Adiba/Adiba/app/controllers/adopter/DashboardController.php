<?php
// app/controllers/adopter/DashboardController.php

class DashboardController
{
    public function index()
    {
        // ✅ user must be logged in and be an adopter
        $user = require_role('adopter');
        $adopterId = (int)($user['user_id'] ?? 0);

        if ($adopterId <= 0) {
            // safety fallback
            $_SESSION = [];
            if (session_status() === PHP_SESSION_ACTIVE) session_destroy();
            redirect('/auth/login');
            return;
        }

        // ✅ Counts are computed from workflow tables (NO users.adoption_requested dependency)
        $totalRequests = 0;
        $petsAdopted = 0;

        // Detect schema: some builds use `adoptions`, some use `adoption_requests`
        $hasAdoptions = false;
        try {
            $st = db()->prepare("SHOW TABLES LIKE 'adoptions'");
            $st->execute();
            $hasAdoptions = (bool)$st->fetch();
        } catch (Exception $e) {
            $hasAdoptions = false;
        }

        try {
            if ($hasAdoptions) {
                // `adoptions` schema
                $stmt = db()->prepare("SELECT COUNT(*) FROM adoptions WHERE adopter_id = ?");
                $stmt->execute([$adopterId]);
                $totalRequests = (int)$stmt->fetchColumn();

                $stmt = db()->prepare("SELECT COUNT(*) FROM adoptions WHERE adopter_id = ? AND LOWER(TRIM(adoption_status)) = 'completed'");
                $stmt->execute([$adopterId]);
                $petsAdopted = (int)$stmt->fetchColumn();
            } else {
                // `adoption_requests` schema
                $stmt = db()->prepare("SELECT COUNT(*) FROM adoption_requests WHERE user_id = ?");
                $stmt->execute([$adopterId]);
                $totalRequests = (int)$stmt->fetchColumn();

                $stmt = db()->prepare("SELECT COUNT(*) FROM adoption_requests WHERE user_id = ? AND LOWER(TRIM(status)) = 'completed'");
                $stmt->execute([$adopterId]);
                $petsAdopted = (int)$stmt->fetchColumn();
            }
        } catch (Exception $e) {
            // If DB error happens, keep counts as 0 and still render the page
            // (No fatal error on dashboard)
        }

        // ✅ Recent request status (for "Recent Requests" card on dashboard)
        // Requirement:
        // - If no requests: show "No Requests Yet"
        // - If found: show "Request [status]" (status from adoptions table)
        $recentText = "No Requests Yet";

        try {
            if ($hasAdoptions) {
                $stmt = db()->prepare("SELECT adoption_status AS st FROM adoptions WHERE adopter_id = ? ORDER BY adoption_id DESC LIMIT 1");
            } else {
                $stmt = db()->prepare("SELECT status AS st FROM adoption_requests WHERE user_id = ? ORDER BY request_id DESC LIMIT 1");
            }
            $stmt->execute([$adopterId]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && isset($row['st'])) {
                $status = strtolower(trim((string)$row['st']));
                if ($status === '') $status = 'pending';
                $recentText = "Request " . $status;
            }
        } catch (Exception $e) {
            // keep default "No Requests Yet"
        }

        // ✅ Pass values to view
        view('adopter/dashboard.php', [
            'user' => $user,
            'petsAdopted' => $petsAdopted,
            'totalRequests' => $totalRequests,
            'recentText' => $recentText,
            'csrf' => csrf_token()
        ]);
    }
}
