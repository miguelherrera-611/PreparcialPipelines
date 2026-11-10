<?php

declare(strict_types=1);

namespace Pronosticos\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Pronosticos\CalculadoraPronosticos;

final class SuavizacionExponencialTest extends TestCase
{
    private const SERIE = [120, 132, 128, 141, 138, 150];

    private CalculadoraPronosticos $calculadora;

    protected function setUp(): void
    {
        $this->calculadora = new CalculadoraPronosticos();
    }

    public function testPronosticaElSiguientePeriodoConAlfa03(): void
    {
        $resultado = $this->calculadora->suavizacionExponencial(self::SERIE, 0.3);

        $this->assertEqualsWithDelta(137.5546, $resultado, 0.01);
    }

    public function testConAlfaCeroElPronosticoNuncaCambia(): void
    {
        $resultado = $this->calculadora->suavizacionExponencial(self::SERIE, 0.0);

        $this->assertEqualsWithDelta(120.00, $resultado, 0.01);
    }

    public function testConAlfaUnoElPronosticoEsLaUltimaDemanda(): void
    {
        $resultado = $this->calculadora->suavizacionExponencial(self::SERIE, 1.0);

        $this->assertEqualsWithDelta(150.00, $resultado, 0.01);
    }

    public function testRechazaAlfaMenorQueCero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Alfa debe estar entre 0 y 1');

        $this->calculadora->suavizacionExponencial(self::SERIE, -0.1);
    }

    public function testRechazaAlfaMayorQueUno(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Alfa debe estar entre 0 y 1');

        $this->calculadora->suavizacionExponencial(self::SERIE, 1.5);
    }
}
