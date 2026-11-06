<?php
declare(strict_types=1);

namespace App\Domain\Entities;

/**
 * Entité Métier Commande & Machine à États
 * Module 8.2 & 8.3
 */
class Order
{
    // Statuts de commande (8.3)
    public const STATUS_PENDING = 'pending';                 // En attente
    public const STATUS_CONFIRMED = 'confirmed';             // Confirmée
    public const STATUS_PAYMENT_PENDING = 'payment_pending'; // Paiement en attente
    public const STATUS_PAID = 'paid';                       // Payée
    public const STATUS_PREPARING = 'preparing';             // En préparation
    public const STATUS_SHIPPED = 'shipped';                 // Expédiée
    public const STATUS_DELIVERED = 'delivered';             // Livrée
    public const STATUS_CANCELLED = 'cancelled';             // Annulée

    // Statuts de paiement séparés
    public const PAYMENT_UNPAID = 'unpaid';
    public const PAYMENT_PENDING = 'pending';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_REFUNDED = 'refunded';

    // Tous les statuts valides
    public const ALL_STATUSES = [
        self::STATUS_PENDING => 'En attente',
        self::STATUS_CONFIRMED => 'Confirmée',
        self::STATUS_PAYMENT_PENDING => 'Paiement en attente',
        self::STATUS_PAID => 'Payée',
        self::STATUS_PREPARING => 'En préparation',
        self::STATUS_SHIPPED => 'Expédiée',
        self::STATUS_DELIVERED => 'Livrée',
        self::STATUS_CANCELLED => 'Annulée',
    ];

    /**
     * Matrice stricte des transitions autorisées (MS-BIZ-06)
     */
    public const VALID_TRANSITIONS = [
        self::STATUS_PENDING => [
            self::STATUS_CONFIRMED,
            self::STATUS_PAYMENT_PENDING,
            self::STATUS_PAID,
            self::STATUS_CANCELLED
        ],
        self::STATUS_CONFIRMED => [
            self::STATUS_PAYMENT_PENDING,
            self::STATUS_PAID,
            self::STATUS_PREPARING,
            self::STATUS_CANCELLED
        ],
        self::STATUS_PAYMENT_PENDING => [
            self::STATUS_PAID,
            self::STATUS_PREPARING,
            self::STATUS_CANCELLED
        ],
        self::STATUS_PAID => [
            self::STATUS_PREPARING,
            self::STATUS_SHIPPED,
            self::STATUS_CANCELLED
        ],
        self::STATUS_PREPARING => [
            self::STATUS_SHIPPED,
            self::STATUS_CANCELLED
        ],
        self::STATUS_SHIPPED => [
            self::STATUS_DELIVERED,
            self::STATUS_CANCELLED
        ],
        self::STATUS_DELIVERED => [],
        self::STATUS_CANCELLED => [],
    ];

    /**
     * Vérifie si la transition d'un statut vers un autre est permise
     */
    public static function canTransition(string $currentStatus, string $newStatus): bool
    {
        if ($currentStatus === $newStatus) {
            return true;
        }
        $allowed = self::VALID_TRANSITIONS[$currentStatus] ?? [];
        return in_array($newStatus, $allowed, true);
    }

    /**
     * Libellé humain d'un statut
     */
    public static function getStatusLabel(string $status): string
    {
        return self::ALL_STATUSES[$status] ?? $status;
    }

    /**
     * Badge CSS pour l'affichage UI
     */
    public static function getStatusBadgeClass(string $status): string
    {
        return match($status) {
            self::STATUS_PENDING => 'bg-amber-100 text-amber-800 border-amber-200',
            self::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800 border-blue-200',
            self::STATUS_PAYMENT_PENDING => 'bg-orange-100 text-orange-800 border-orange-200',
            self::STATUS_PAID => 'bg-teal-100 text-teal-800 border-teal-200',
            self::STATUS_PREPARING => 'bg-indigo-100 text-indigo-800 border-indigo-200',
            self::STATUS_SHIPPED => 'bg-purple-100 text-purple-800 border-purple-200',
            self::STATUS_DELIVERED => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            self::STATUS_CANCELLED => 'bg-red-100 text-red-800 border-red-200',
            default => 'bg-gray-100 text-gray-800 border-gray-200',
        };
    }
}
