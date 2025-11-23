<?php

declare(strict_types=1);

namespace Cecapta\IntegraApi\Domain\ValueObject;

/**
 * Enum que representa las plataformas de campañas
 */
enum Plataforma: string
{
    case FACEBOOK = 'FACEBOOK';
    case GOOGLE = 'GOOGLE';
    case INSTAGRAM = 'INSTAGRAM';
    case TIKTOK = 'TIKTOK';
    case LINKEDIN = 'LINKEDIN';
    case TWITTER = 'TWITTER';
    case YOUTUBE = 'YOUTUBE';
    case OTRO = 'OTRO';

    public static function fromString(string $plataforma): self
    {
        return self::tryFrom(strtoupper($plataforma)) ?? self::OTRO;
    }
}
