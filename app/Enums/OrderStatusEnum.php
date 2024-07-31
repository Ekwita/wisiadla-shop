<?php

namespace App\Enums;

class OrderStatusEnum
{
    const NEW = 'New'; //Nowy
    const WAITING = 'Waiting for payment'; //Oczekuje na płatność
    const PROGRESS = 'In progress'; //W przygotowaniu
    const SHIPPED = 'Shipped'; // W doręczeniu
    const DELIVERED = 'Delivered'; //Dostarczona
    const CANCELLED = 'Cancelled'; //Anulowany
    const REFUND = 'Refund'; // Zwrot
    const COMPLAINT = 'Complaint'; // Reklamacja



    const STATUS = [
        self::NEW,
        self::WAITING,
        self::PROGRESS,
        self::SHIPPED,
        self::DELIVERED,
        self::CANCELLED,
        self::REFUND,
        self::COMPLAINT
    ];
    
}
