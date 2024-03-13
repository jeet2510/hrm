<?php

use PHPUnit\Framework\TestCase;

class SalaryCalculationServiceTest extends TestCase
{
    public function testTaxDeductionNoAllowancesNoTaxDeductions()
    {
        $employee = new Employee();
        $employee->salary = 50000;
        $employee->salary_type = 'monthly';

        $taxCalculator = new TaxCalculator();
        $result = $taxCalculator->taxDeduction($employee);

        $this->assertEquals(0, $result);
    }

    public function testTaxDeductionWithAllowancesNoTaxDeductions()
    {
        $employee = new Employee();
        $employee->salary = 60000;
        $employee->salary_type = 'monthly';

        $allowance = new Allowance();
        $allowance->amount = 5000;

        $taxCalculator = new TaxCalculator();
        $result = $taxCalculator->taxDeduction($employee);

        $this->assertEquals(0, $result);
    }

    public function testTaxDeductionNoAllowancesWithTaxDeductions()
    {
        $employee = new Employee();
        $employee->salary = 70000;
        $employee->salary_type = 'monthly';

        $taxDeduction = new TaxDeduction();
        $taxDeduction->total_deduction = 2000;

        $taxCalculator = new TaxCalculator();
        $result = $taxCalculator->taxDeduction($employee);

        $this->assertEquals(2000, $result);
    }

    public function testTaxDeductionWithAllowancesAndTaxDeductions()
    {
        $employee = new Employee();
        $employee->salary = 80000;
        $employee->salary_type = 'monthly';

        $allowance = new Allowance();
        $allowance->amount = 5000;

        $taxDeduction = new TaxDeduction();
        $taxDeduction->total_deduction = 3000;

        $taxCalculator = new TaxCalculator();
        $result = $taxCalculator->taxDeduction($employee);

        $this->assertEquals(27000, $result);
    }
}