<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Contract_merge_fields extends App_merge_fields
{
    public function build()
    {
        return [
                [
                    'name'      => 'قرداد ID',
                    'key'       => '{contract_id}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'موضوع قرداد',
                    'key'       => '{contract_subject}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'توضیحات قرداد',
                    'key'       => '{contract_description}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'تاریخ شروع قرارداد',
                    'key'       => '{contract_datestart}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'تاریخ اتمام قرارداد',
                    'key'       => '{contract_dateend}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'مبلغ قرداد',
                    'key'       => '{contract_contract_value}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'لینک قرداد',
                    'key'       => '{contract_link}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'توع قرارداد',
                    'key'       => '{contract_type}',
                    'available' => [
                        'contract',
                    ],
                ],
                [
                    'name'      => 'نام پروژه',
                    'key'       => '{project_name}',
                    'available' => [
                        'contract',
                    ],
                ],
            ];
    }

    /**
     * Merge field for contracts
     * @param  mixed $contract_id contract id
     * @return array
     */
    public function format($contract_id)
    {
        $fields = [];
        $this->ci->db->select(db_prefix() . 'contracts.id as id, subject, description, datestart, dateend, contract_value, hash, project_id, ' . db_prefix() . 'contracts_types.name as type_name');
        $this->ci->db->where('contracts.id', $contract_id);
        $this->ci->db->join(db_prefix() . 'contracts_types', '' . db_prefix() . 'contracts_types.id = ' . db_prefix() . 'contracts.contract_type', 'left');
        $contract = $this->ci->db->get(db_prefix() . 'contracts')->row();

        if (!$contract) {
            return $fields;
        }

        $currency = get_base_currency();

        $fields['{contract_id}']             = $contract->id;
        $fields['{contract_subject}']        = $contract->subject;
        $fields['{contract_type}']           = $contract->type_name;
        $fields['{contract_description}']    = nl2br($contract->description);
        $fields['{contract_datestart}']      = to_view_date_custom($contract->datestart);
        $fields['{contract_dateend}']        = to_view_date_custom($contract->dateend);
        $fields['{contract_contract_value}'] = app_format_money($contract->contract_value, $currency);

        $fields['{contract_link}']      = site_url('contract/' . $contract->id . '/' . $contract->hash);
        $fields['{project_name}']       = get_project_name_by_id($contract->project_id);
        $fields['{contract_short_url}'] = get_contract_shortlink($contract);

        $custom_fields = get_custom_fields('contracts');
        foreach ($custom_fields as $field) {
            $fields['{' . $field['slug'] . '}'] = get_custom_field_value($contract_id, $field['id'], 'contracts');
        }

        return hooks()->apply_filters('contract_merge_fields', $fields, [
        'id'       => $contract_id,
        'contract' => $contract,
     ]);
    }
}
