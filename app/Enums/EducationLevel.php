<?php

namespace App\Enums;

enum EducationLevel: int 
{
    
    case EnsinoFundamentalIncompleto = 1;
    case EnsinoFundamentalCompleto = 2;
    case EnsinoMedioIncompleto = 3;
    case EnsinoMedioCompleto = 4;
    case EnsinoSuperiorIncompleto = 5;
    case EnsinoSuperiorCompleto = 6;

    public static function forSelect(): array 
    {
        return [
            self::EnsinoFundamentalIncompleto->name => [
                'label' => 'Ensino Fundamental Incompleto',
                'value' => 1
            ],
            self::EnsinoFundamentalCompleto->name => [
                'label' => 'Ensino Fundamental Completo',
                'value' => 2
            ],
            self::EnsinoMedioIncompleto->name => [
                'label' => 'Ensino Médio Incompleto',
                'value' => 3
            ],
            self::EnsinoMedioCompleto->name => [
                'label' => 'Ensino Médio Completo',
                'value' => 4
            ],
            self::EnsinoSuperiorIncompleto->name => [
                'label' => 'Ensino Superior Incompleto',
                'value' => 5
            ],
            self::EnsinoSuperiorCompleto->name => [
                'label' => 'Ensino Superior Completo',
                'value' => 6
            ]
        ];
    }

    public static function label(int $value): string
    {
        switch ($value) {
            case 1:
                return 'Ensino Fundamental Incompleto';
                break;
            case 2:
                return 'Ensino Fundamental Completo';
                break;
            case 3:
                return 'Ensino Médio Incompleto';
                break;
            case 4:
                return 'Ensino Médio Completo';
                break;
            case 5:
                return 'Ensino Superior Incompleto';
                break;
            case 6:
                return 'Ensino Superior Completo';
                break;
            
            
        }
    }
}