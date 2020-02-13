<?php

namespace App;

class AnnualConverter
{
    protected $dateFields = [
        'startdatum van de huidige financiële rapportageperiode' => 'curr_date',
        'startdatum van de voorgaande financiële rapportageperiode' => 'prev_date',
    ];

    protected $balanceSheetFields = [
        // goodwill: assets_fix_intangible_goodwill
        // overige immateriële activa: overige_immateriele_activa
        'immateriële vaste activa' => 'assets_fix_intangible_total', // immateriële vaste activa
        // bedrijfsgebouwen: assets_fix_tangible_buildings
        // machines: assets_fix_tangible_machines
        // inventaris: assets_fix_tangible_inventory
        // overig materiële activa: assets_fix_tangible_other
        'materiële vaste activa' => 'assets_fix_tangible_total', // materiele vaste activa,
        // verbonden ondernemingen: assets_fix_financial_rel_companies
        // verstrekte vaste leningen: assets_fix_financial_loans
        // andere financiële activa: assets_fix_financial_other
        'financiële vaste activa' => 'assets_fix_financial_total', // financiele vaste activa
        // overige vaste activa: assets_fix_other
        'vaste activa' => 'assets_fix_total', // vaste activa
        'totaal van vaste activa' => 'assets_fix_total', // vaste activa
        // voorraad grondstoffen: assets_cur_stocks_materials
        'onderhanden projecten (activa)' => 'assets_cur_stocks_projects_in_progress', // onderhanden werk
        // afgewerkte producten: assets_cur_stocks_finished_products
        // vooruitbetalingen: assets_cur_stocks_advanced_payments
        // overige voorraden: assets_cur_stocks_other
        'voorraden' => 'assets_cur_stocks',
        // handelsdebiteuren: assets_cur_receivable_debtors
        // vorderingen langer dan 1 jaar: assets_cur_receivable_gt_one_year
        // vorderingen korter dan 1 jaar: assets_cur_receivable_lt_one_year
        // belastingvorderingen: assets_cur_receivable_tax
        // verstrekte leningen: assets_cur_receivable_loans
        // vordering(en) groepsmaatschappijen: assets_cur_receivable_rel_parties
        // vordering(en) groepsmaatschappijen: assets_cur_receivable_rel_parties
        // overige vorderingen: assets_cur_receivable_other
        'vorderingen' => 'assets_cur_receivable_total', // totaal vorderingen
        // effecten: assets_cur_funds
        'liquide middelen' => 'assets_cur_liquid', // liquide middelen
        // overige vlottende activa: assets_cur_other
        // overlopende rekeningen: assets_cur_accruals
        'vlottende activa' => 'assets_cur_total', // vlottende activa
        'totaal van vlottende activa' => 'assets_cur_total', // vlottende activa
        'activa' => 'assets_total', // balanstotaal
        'totaal van activa' => 'assets_total', // balanstotaal
        // geplaats kapitaal: liabilities_capandres_issued_capital
        // totaal reserves: liabilities_capandres_reserves_total
        'agio' => 'liabilities_capandres_reserves_share_premium', // agioreserve
        // herwaardering reserves: liabilities_capandres_reserves_revaluation
        // wettelijke reserves: liabilities_capandres_reserves_legal_statutory
        'overige reserves' => 'liabilities_capandres_reserves_other', // overige reserves
        'onverdeelde winst' => 'liabilities_capandres_non_distributable_profit', // onverdeelde winst
        'resultaat van het boekjaar' => 'liabilities_capandres_non_distributable_profit', // onverdeelde winst
        'aandelenkapitaal' => 'liabilities_capandres_shareholders', // totaal eigen vermogen aandeelhouders
        'totaal van groepsvermogen' => 'liabilities_capandres_shareholders', // totaal eigen vermogen aandeelhouders
        'aandeel van derden' => 'liabilities_capandres_minority_interest', // minderheidsbelangen
        'eigen vermogen' => 'liabilities_capandres_total', // totaal eigen vermogen
        'totaal van eigen vermogen' => 'liabilities_capandres_total', // totaal eigen vermogen
        'voorzieningen' => 'liabilities_provisions', // pensioen verplichtingen
        // pensioen verplichtingen: liabilities_lt_pension
        // langlopende rentedragende schulden: liabilities_lt_interest_yealding
        // financiële schulden: liabilities_lt_financial
        // belastingschulden: liabilities_lt_taxes
        // schulden binnen de groep: liabilities_lt_rel_companies
        // overige langlopende schulden: liabilities_lt_other
        'langlopende schulden' => 'liabilities_lt_total', // langlopende schulden
        'langlopende schulden (nog voor meer dan een jaar)' => 'liabilities_lt_total', // langlopende schulden
        // handelskredieten: liabilities_st_trade_credit
        // pensioen verplichtingen: liabilities_st_pension
        // rekeningcourant: liabilities_st_current_account
        // schulden aan kredietinstellingen: liabilities_st_credit_institutions
        // kortlopende rentedragende schulden: liabilities_st_interest_yielding
        // financiële schulden: liabilities_st_financial
        // belastingschulden: liabilities_st_taxes
        // schulden binnen de groep: liabilities_st_rel_companies
        // overige kortlopende schulden: liabilities_st_other
        'kortlopende schulden' => 'liabilities_st_total', // kortlopende schulden
        'kortlopende schulden en overlopende passiva' => 'liabilities_st_total', // kortlopende schulden
        // overige passiva: liabilities_other
        // overlopende rekeningen: liabilities_accruals
        // totaal vreemd vermoge: liabilities_debts
        'passiva' => 'liabilities_total', // balanstotaal credit
        'totaal van passiva' => 'liabilities_total', // balanstotaal credit
    ];

    protected $profitLossAccountFields = [
        // opbrengsten: income_revenue
        // overige bedrijfsopbrengsten: income_other
        // netto omzet: income_total
        // kostprijs omzet: income_costs
        'bruto-bedrijfsresultaat' => 'income_result', // bruto marge
        // bijkomende bedrijfsopbrengsten: income_additional
        'lasten uit hoofde van personeelsbeloningen' => 'costs_employees', // personeelskosten
        // sociale lasten: costs_social_securities
        // pensioenpremies: costs_pension
        'afschrijvingen op immateriële en materiële vaste activa' => 'costs_depreciation_and_amortization_1',  // afschrijvingen en amortisatie
        'bijzondere waardeverminderingen van vlottende activa' => 'costs_depreciation_and_amortization_2',  // afschrijvingen en amortisatie
        'waardeveranderingen van immateriële en materiële vaste activa' => 'costs_depreciation_and_amortization_3',  // afschrijvingen en amortisatie
        'verkoopkosten' => 'costs_sales', // verkoop kosten
        'overige bedrijfskosten' => 'costs_other', // Overige bedrijfslasten
        // productiekosten: costs_production
        // grond- en hulpstoffen: costs_materials
        // mutaties voorraden gereed product en goederen in bewerking: costs_stocks
        'totaal van som der kosten' => 'costs_total', // bedrijfslasten
        // aandeel in w/v deelnemingen: participations
        'totaal van bedrijfsresultaat' => 'operating_result', // bedrijfsresultaat
        // financiële baten: financial_gains
        // financiële lasten: financial_charges
        'financiële baten en lasten' => 'financial_result', // saldo financiële baten/lasten
        // overige baten: other_gains
        // overige lasten: other_charges
        'waardeveranderingen van financiële vaste activa en van effecten' => 'other_result', // overig resultaat
        'opbrengst van vorderingen die tot de vaste activa behoren en van effecten' => 'other_result', // overig resultaat
        'aandeel in resultaat van ondernemingen waarin wordt deelgenomen' => 'participations_result', // resultaat uit gewone bedrijfsuitoefening voor belasting
        'totaal van resultaat voor belastingen' => 'business_result', // belasting uit bedrijfsuitoefening
        'belastingen over de winst of het verlies' => 'business_result_tax', // resultaat uit gewone bedrijfsuitoefening na belasting
        // resultaat uit gewone bedrijfsuitoefening na belasting: business_result_after_tax
        // buitengewone baten: extraordinary_gains
        // buitengewone lasten: extraordinary_charges
        // buitengewoon resultaat voor belasting: extraordinary_result
        // belasting buitengewoon resultaat: extraordinary_result_tax
        // buitengewoon resultaat na belasting: extraordinary_result_after_tax
        // overige belastingen: other_tax
        // financierings activiteiten/uitgifte nieuwe aandelen: investment_financing
        // resultaat uit deelnemingen na belasting: participations_result_after_tax
        // overig resultaat na belasting: other_result_after_tax
        'totaal van resultaat na belastingen' => 'result', // netto resultaat
        'nettoresultaat na belastingen' => 'result', // netto resultaat
        'resultaat toekomend aan de rechtspersoon' => 'result', // netto resultaat
        'resultaat aandeel van derden' => 'attributable_minority_interest', // toe te rekenen aan derden
        // aandeelhouders: shareholders
    ];

    protected $months = [
        'januari',
        'februari',
        'maart',
        'april',
        'mei',
        'juni',
        'juli',
        'augustus',
        'september',
        'oktober',
        'november',
        'december',
    ];

    protected $tmpPath;

    public function __construct($tmpPath)
    {
        $this->tmpPath = $tmpPath;
    }

    public function convert($file)
    {
            $tmpFile = sprintf('%s/%s.txt', $this->tmpPath, uniqid());
            $command = sprintf('pdftotext -layout %s %s', $file, $tmpFile);

            exec($command);

            if (! ($contents = file_get_contents($tmpFile))) {
                return;
            }

            @unlink($tmpFile);

            echo '<pre>';
            $result = explode("\n", $contents);
            $test1 = "  Production plant and machinery";
            $test2 = "  222222222 33333333333";
            $test3 = "  5    AAAA";
            $test4 = "  Production plant and machinery                                          1163800    1356217 ";
            $test5 = "  5    Production plant and machinery                                          1.163.800    1.356.217";

            $y = preg_match_all("/^[\s]*[0-9][\s][0-9]*/ms", $test5, $matches);            

            foreach ($result as $key => $value) {
                //echo '<br>';
                //print_r($value);
                //$pattern = "/^[\s]*\w*[\s]*[0-9]*/ms";
                //$pattern = "/^*\w*[0-9]*[\s]*[0-9]*/ms";
                //preg_match_all("/^[\s]*\w*[\s]*[0-9]*[0-9]*/ms", $value, $matches);
                //$y = preg_match_all("/^[\s]*[0-9][\s][0-9]*/ms", $value, $matches);
                
                // if($y == 1){
                //    print_r($value);
                //     echo '<br/>'; 
                // }
                
                $z = preg_match_all("/[^ ]*[0-9][\s][0-9]*[^a-z]*$/ms", trim($value), $matches);    
                if($z == 1){
                    
                    // print_r($value);
                    // echo '<br/><br/>'; 
                    
                    //$output = preg_replace('/\s+/', ' ',$value);
                    //print_r(str_replace(" ", "-", $output));
                    


                    if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬]/', $value))
                    {
                        
                        if (preg_match('/[ ]{10,}/', trim($value)))
                        {
                            //echo "Yes";
                            $numbers = preg_replace('/[^0-9]/', ' ', $value);
                            $letters = preg_replace('/[^a-zA-Z]/', ' ', $value);
                            
                            print_r(trim($value));
                            echo '<br/><br/>'; 
                            print_r(trim($letters));

                            $test = explode(trim($letters), $value);
                            print_r($test);

                            echo '<br/><br/>'; 

                            echo '<br/><br/>'; 
                            echo '=============================================='; 
                            echo '=============================================='; 
                            echo '=============================================='; 
                            echo '<br/><br/>'; 
                        }
                        else
                        {
                            //echo "No";
                        }

                        
                    }

                    // $test = explode("\s", $value);
                    // print_r($test);
                }

            }            
            exit();

            $colPattern = sprintf(
                '~^
                \s+?
                (?:\d{1,2}\s(?:%s)\s\d{4}|\d{4}|\d{4}-\d{1,2}-\d{1,2})
                \s+?
                (\d{1,2}\s(?:%s)\s\d{4}|\d{4}|\d{4}-\d{1,2}-\d{1,2})
                \s*?
                $~x',
                implode('|', $this->months),
                implode('|', $this->months)
            );

            $filteredDate  = [];
            $filteredBalanceSheet  = [];
            $filteredProfitLossAccount = [];
            $dateKeys = array_keys($this->dateFields);
            $balanceSheetKeys = array_keys($this->balanceSheetFields);
            $profitLossAccountKeys = array_keys($this->profitLossAccountFields);
            $colBoundary = null;
            $lines = explode("\n", mb_strtolower(utf8_encode($contents)));


            foreach ($lines as $line) {                

             // $pattern = "/^\w*?\s\d+$/";
             // $pattern = "/^[a-z]\s*[0-9]*$/";

             // $text = $line;            
             // $matches = preg_match_all($pattern, $text, $array);

            
            

            if (preg_match($colPattern, $line, $match)) {
               $pos = strpos($line, $match[1]);
                $len = strlen($match[1]);
                $min = 20;
                $colBoundary = $len < $min ? $pos + $len - $min : $pos;
            } elseif (($result = $this->filterDate($line, $dateKeys))) {
                $field = $this->dateFields[$result[0]];
                $filteredDate[$field] = $result[1];
            } elseif (($result = $this->filterNumbers($line, $balanceSheetKeys, $colBoundary))) {
                $field = $this->balanceSheetFields[$result[0]];
                if (! array_key_exists($field, $filteredBalanceSheet)) {
                    $filteredBalanceSheet[$field] = $result[1];
                }
            } elseif (($result = $this->filterNumbers($line, $profitLossAccountKeys, $colBoundary))) {
                $field = $this->profitLossAccountFields[$result[0]];
                if (! array_key_exists($field, $filteredProfitLossAccount)) {
                    $filteredProfitLossAccount[$field] = $result[1];
                }
            }
        }

        exit();

        $currDate = $this->arrayGet('curr_date', $filteredDate);
        $prevDate = $this->arrayGet('prev_date', $filteredDate);
        $result = [];

        
        

        if (($items = $this->makeItems(
            $filteredBalanceSheet,
            $currDate,
            $prevDate,
            true,
            [$this, 'validateBalanceSheet']))) {
            $result['balance_sheets'] = $items;
        }



        if (($items = $this->makeItems(
            $filteredProfitLossAccount,
            $currDate,
            $prevDate,
            false))) {
            $result['profit_loss_accounts'] = $items;
        }

        print_r($filteredBalanceSheet);
        exit();
        if ($result) {
            return $result;
        }
    }

    protected function makeItems(
        array $filtered,
        $currDate,
        $prevDate,
        $includeDate,
        callable $validator = null
    ) {
        $currItem = [];
        $prevItem = [];

        foreach ($filtered as $field => $values) {
            $currValue = 0;
            $prevValue = 0;

            if (preg_match('~^(.*?)_\d+$~', $field, $match)) {
                $field = $match[1];
                $currValue = $this->arrayGet($field, $currItem, 0);
                $prevValue = $this->arrayGet($field, $prevItem, 0);
            }

            if (($value = array_shift($values)) !== null) {
                $currItem[$field] = $currValue + $value;
            }

            if (($value = array_shift($values)) !== null) {
                $prevItem[$field] = $prevValue + $value;
            }
        }

        if (empty($currItem)) {
            return;
        }

        $currHead = ['year' => substr($currDate, 0, 4)];
        $prevHead = ['year' => substr($prevDate, 0, 4)];

        if ($includeDate) {
            $currHead['date'] = $currDate;
            $prevHead['date'] = $prevDate;
        }

        $items = [array_merge($currHead, $currItem)];

        if (! empty($prevItem)) {
            $items[] = array_merge($prevHead, $prevItem);
        }

        if (! $validator) {
            return $items;
        }

        $validatedItems = [];

        foreach ($items as $item) {
            if (($validatedItem = call_user_func($validator, $item))) {
                $validatedItems[] = $validatedItem;
            }
        }

        return $validatedItems;
    }

    protected function validateBalanceSheet(array $item)
    {
        $assetsTotal = $this->arrayGet('assets_total', $item);
        $liabilitiesTotal = $this->arrayGet('liabilities_total', $item);

        $assetsSum = $this->arrayGet('assets_fix_total', $item)
            + $this->arrayGet('assets_cur_total', $item);

        $liabilitiesSum = $this->arrayGet('liabilities_capandres_total', $item)
            + $this->arrayGet('liabilities_provisions', $item)
            + $this->arrayGet('liabilities_lt_total', $item)
            + $this->arrayGet('liabilities_st_total', $item);

        if ($assetsTotal === null
            || $liabilitiesTotal === null
            || $assetsTotal !== $liabilitiesTotal
            || $assetsSum !== $assetsTotal
            || $liabilitiesSum !== $liabilitiesTotal) {
            return;
        }

        return $item;
    }

    protected function filterDate($line, array $fields)
    {
        $datePattern = sprintf(
            '~(\d{1,2})( (?:%s) |-\d{1,2}-)(\d{4})~',
            implode('|', $this->months)
        );

        foreach ($fields as $field) {
            // use a max length, some fields use multiple lines
            $maxLen = substr($field, 0, 50);
            $quoted = preg_quote($maxLen, '~');
            $fieldPattern = sprintf('~^%s~', $quoted);
            if (! preg_match($fieldPattern, trim($line))) {
                continue;
            }

            if (preg_match($datePattern, $line, $match)) {
                $date = $this->formatDate($match[1], trim($match[2], ' -'), $match[3]);
                return [$field, $date];
            }
        }
    }

    protected function filterNumbers($line, array $fields, $colBoundary = null)
    {
        foreach ($fields as $field) {
            // use a max length, some fields use multiple lines
            $maxLen = substr($field, 0, 50);
            $quoted = preg_quote($maxLen, '~');
            $fieldPattern = sprintf('~^%s~', $quoted);
            if (preg_match($fieldPattern, trim($line))
                && preg_match_all('~(-?[\d.]+)~', $line, $match)) {
                $numbers = $this->formatNumbers(array_slice($match[0], -2, 2));
                if (count($numbers) == 1) {
                    $pos = strpos($line, $match[0][0]);
                    if ($colBoundary > $pos) {
                        $numbers = [$numbers[0], null];
                    } else {
                        $numbers = [null, $numbers[0]];
                    }
                }
                return [$field, $numbers];
            }
        }
    }

    protected function formatDate($day, $month, $year)
    {
        if (($index = array_search($month, $this->months, true)) !== false) {
            $month = $index + 1;
        }

        return implode('-', [
            $year,
            str_pad($month, 2, '0', STR_PAD_LEFT),
            str_pad($day, 2, '0', STR_PAD_LEFT)
        ]);
    }

    protected function formatNumbers(array $numbers)
    {
        foreach ($numbers as $index => $number) {
            $numbers[$index] = (int) str_replace('.', '', $number);
        }

        return $numbers;
    }

    protected function arrayGet($key, array $array, $default = null)
    {
        return array_key_exists($key, $array) ? $array[$key] : $default;
    }
}
