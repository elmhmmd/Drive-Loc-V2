<?php
session_start();

// Fake statistics data
$stats = [
    'total_vehicles' => 24,
    'active_rentals' => 12,
    'total_users' => 156,
    'pending_reviews' => 8
];

// Fake recent activities
$recent_activities = [
    [
        'date' => '2024-01-15',
        'client' => 'Jean Dupont',
        'action' => 'Location de véhicule',
        'status' => 'Confirmé'
    ],
    [
        'date' => '2024-01-14',
        'client' => 'Marie Martin',
        'action' => 'Retour de véhicule',
        'status' => 'Complété'
    ],
    [
        'date' => '2024-01-14',
        'client' => 'Pierre Lambert',
        'action' => 'Nouveau avis',
        'status' => 'En attente'
    ],
    [
        'date' => '2024-01-13',
        'client' => 'Sophie Bernard',
        'action' => 'Location de véhicule',
        'status' => 'En cours'
    ]
];
?>

<!DOCTYPE html>
<html lang="fr">
<!-- [Previous head section remains the same] -->

<!-- In the table body, replace the comment with: -->
<tbody>
    <?php foreach ($recent_activities as $activity): ?>
    <tr>
        <td><?= $activity['date'] ?></td>
        <td><?= $activity['client'] ?></td>
        <td><?= $activity['action'] ?></td>
        <td>
            <span class="badge bg-<?= 
                $activity['status'] === 'Confirmé' ? 'success' : 
                ($activity['status'] === 'En attente' ? 'warning' : 
                ($activity['status'] === 'En cours' ? 'primary' : 'secondary')) 
            ?>">
                <?= $activity['status'] ?>
            </span>
        </td>
    </tr>
    <?php endforeach; ?>
</tbody>
