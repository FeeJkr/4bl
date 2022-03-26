import {React} from "react";

export const vatRejectionOptions = [
    {value: 1, label: 'Zwolnienie ze względu na nieprzekroczenie 200 000 PLN obrotu (art. 113 ust 1 i 9 ustawy o VAT)'},
    {value: 2, label: 'Zwolnienie na mocy rozporządzenia MF (art. 82 ust 3 ustawy o VAT)'},
    {value: 3, label: 'Zwolnienie ze względu na rodzaj prowadzonej działalności (art. 43 ust 1 ustawy o VAT)'},
    {value: 4, label: 'Inna podstawa prawna', isDisabled: true}
];