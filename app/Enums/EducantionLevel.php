<?php

namespace App\Enums;

enum EducationLevel: int {
    
    case EnsinoFundamentalIncompleto = 1;
    case EnsinoFundamentalCompleto = 2;
    case EnsinoMedioIncompleto = 3;
    case EnsinoMedioCompleto = 4;
    case EnsinoSuperiorIncompleto = 5;
    case EnsinoSuperiorCompleto = 6;
}