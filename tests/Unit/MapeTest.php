<?php

declare(strict_types=1);

namespace Pronosticos\Tests\Unit;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Pronosticos\CalculadoraPronosticos;

/** Pruebas unitarias del error porcentual absoluto medio (MAPE). */
final class MapeTest extends TestCase
{
    private CalculadoraPronosticos $calculadora;

    protected function setUp(): void
    {
        $this->calculadora = new CalculadoraPronosticos();
    }

    public function testCalculaElErrorPorcentualAbsolutoMedio(): void
    {
        $resultado = $this->calculadora->mape([141, 138, 150], [126.67, 133.67, 135.67]);

        $this->assertEqualsWithDelta(7.62, $resultado, 0.01);
    }

    public function testExcluyeLosPeriodosConDemandaCero(): void
    {
        $resultado = $this->calculadora->mape([80, 0, 95], [80, 0, 100]);

        // El periodo con demanda 0 se excluye; el promedio se calcula sobre los
        // otros 2 periodos, no sobre los 3.
        $this->assertEqualsWithDelta(2.63, $resultado, 0.01);
    }

    public function testFallaCuandoNoHayPeriodosValidos(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->calculadora->mape([0, 0], [10, 20]);
    }
}
