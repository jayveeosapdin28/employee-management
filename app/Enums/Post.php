<?php

namespace App\Enums;

enum Post: string
{
    case FrontendDeveloper = 'Frontend Developer';
    case MernDeveloper = 'Mern Developer';
    case PythonDeveloper = 'Python Developer';
    case FullStackDeveloper = 'Full Stack Developer';
    case WebDeveloper = 'Web Developer';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
