<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018301', 'part_name' => 'PLATE ASSEMBLY REAR', 'category' => 'Back Plate', 'style_bom' => 'BP VT6'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018303', 'part_name' => 'PLATE ASSEMBLY REAR', 'category' => 'Back Plate', 'style_bom' => 'BP VT7'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018309', 'part_name' => 'PLATE ASSEMBLY REAR', 'category' => 'Back Plate', 'style_bom' => 'BP VT4'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018318', 'part_name' => 'PLATE ASSEMBLY REAR', 'category' => 'Back Plate', 'style_bom' => 'BP VT12'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018319', 'part_name' => 'PLATE ASSEMBLY REAR', 'category' => 'Back Plate', 'style_bom' => 'VT 10'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU74348515', 'part_name' => 'Plate Assembly Rear', 'category' => 'Back Plate', 'style_bom' => 'OMEGA 6'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU74348517', 'part_name' => 'Plate Assembly Rear', 'category' => 'Back Plate', 'style_bom' => 'OMEGA 8'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU74348518', 'part_name' => 'Plate Assembly Rear', 'category' => 'Back Plate', 'style_bom' => 'OMEGA 9'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGU30018320', 'part_name' => 'PLATE ASSEMBLY,REAR', 'category' => 'Back Plate', 'style_bom' => 'VT 11'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4117ACR1111L', 'part_name' => 'BACK PLATE 1D 170L', 'category' => 'Back Plate', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4165EAT1111L', 'part_name' => 'BACK PLATE ECO 1D 165L', 'category' => 'Back Plate', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4175EAT1111L', 'part_name' => 'BACK PLATE ECO 1D 175L', 'category' => 'Back Plate', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S18ACR1111L', 'part_name' => 'BACK PLATE SC 175L', 'category' => 'Back Plate', 'style_bom' => 'SHOW CASE'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0391L', 'part_name' => 'BOTTLE OPENER', 'category' => 'Bottle', 'style_bom' => 'SHOW CASE - SKD'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4116ACR1121L', 'part_name' => 'BOTTOM PLATE 1D', 'category' => 'Bottom Plate', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4218ACR1121L', 'part_name' => 'BOTTOM PLATE 2D', 'category' => 'Bottom Plate', 'style_bom' => 'REFRIGERATOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21ACR1121L', 'part_name' => 'BOTTOM PLATE SAS SC', 'category' => 'Bottom Plate', 'style_bom' => 'SHOW CASE'],
            ['customer' => 'PT. HASURA MITRA GEMILANG', 'part_number' => '4810JM3004B', 'part_name' => 'BRACKET,DOOR', 'category' => 'Bracket', 'style_bom' => 'PRESS SPCC T2.3 SCP1 NATURAL T2.0 DIAMOND PJT'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJB63210101', 'part_name' => 'BRACKET DOOR OMEGA', 'category' => 'Bracket', 'style_bom' => 'OMEGA'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MAZ65643601', 'part_name' => 'Bracket handel Alpha 8', 'category' => 'Bracket', 'style_bom' => 'ALPHA 8 F'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MAZ65643701', 'part_name' => 'Bracket handel Alpha 8', 'category' => 'Bracket', 'style_bom' => 'ALPHA 8 R'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MAZ63110101', 'part_name' => 'Bracket,Handle', 'category' => 'Bracket', 'style_bom' => 'SEGITIGA'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MAZ63130101', 'part_name' => 'Bracket,Handle', 'category' => 'Bracket', 'style_bom' => 'KLAUS KECIL'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MBN63922902', 'part_name' => 'CASE PCB COMANG', 'category' => 'Case PCB', 'style_bom' => 'VIPER KOREA'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MBN63922905', 'part_name' => 'CASE PCB FREEZER INVENTER', 'category' => 'Case PCB', 'style_bom' => 'FREEZER'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MBN63922901', 'part_name' => 'CASE PCB GLORY', 'category' => 'Case PCB', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MBN63922904', 'part_name' => 'CASE PCB GLORY REACTOR', 'category' => 'Case PCB', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0314L', 'part_name' => 'CASTER PIN', 'category' => 'CASTER PIN', 'style_bom' => 'SHOW CASE - SKD'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30056405', 'part_name' => 'BASE ASSEMBLY COMPRESSOR', 'category' => 'Comp Base', 'style_bom' => 'CB VT12'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN75770703', 'part_name' => 'BASE ASSEMBLY COMPRESSOR NEW FREZER', 'category' => 'Comp Base', 'style_bom' => 'NEW FZR'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30029904', 'part_name' => 'BASE ASSEMBLY COMPRESSOR VT18', 'category' => 'Comp Base', 'style_bom' => 'CB VT18'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN73829507', 'part_name' => 'BASE ASSEMBLY,COMPRESSOR', 'category' => 'Comp Base', 'style_bom' => 'ALPHA 4,5 PJT 101.6 X 165.1 US PITCH'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN74552005', 'part_name' => 'Base Assembly,Compressor', 'category' => 'Comp Base', 'style_bom' => 'OMEGA LONG'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN75770702', 'part_name' => 'Base Assembly,Compressor', 'category' => 'Comp Base', 'style_bom' => 'FREEZER GTF'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30029906', 'part_name' => 'BASE ASSEMBLY,COMPRESSOR VT 18N', 'category' => 'Comp Base', 'style_bom' => 'VT 18 PMG'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN74552005 OSP', 'part_name' => 'OSP COST ASSEMBLY SGCC OMEGA 6,8,9 N', 'category' => 'Comp Base', 'style_bom' => 'OMEGA LONG'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30029904 OSP', 'part_name' => 'OSP COST BASE ASSEMBLY COMPRESSOR VT18', 'category' => 'Comp Base', 'style_bom' => 'CB VT18'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30029906 OSP', 'part_name' => 'OSP COST BASE ASSEMBLY COMPRESSOR, VT 18', 'category' => 'Comp Base', 'style_bom' => 'CB VT 1'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AAN30056405 OSP', 'part_name' => 'OSP COST BASE ASSEMBLY COMPRESSOR, VT12', 'category' => 'Comp Base', 'style_bom' => 'VT12'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0851L', 'part_name' => 'COMPRESSOR BASE (SC)', 'category' => 'Comp Base', 'style_bom' => 'REFRIGERATOR 2 DOOR'],
            ['customer' => 'PT. DAESOUNG ELECTRIC COMPONENTS', 'part_number' => 'MCK67989701', 'part_name' => 'COVER CONNECTOR (NEW)', 'category' => 'Cover PCB', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. DAESOUNG ELECTRIC COMPONENTS', 'part_number' => 'MCK67989703', 'part_name' => 'COVER CONNECTOR KECIL NEW', 'category' => 'Cover PCB', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. DAESOUNG ELECTRIC COMPONENTS', 'part_number' => 'MCK71382401', 'part_name' => 'COVER CONNECTOR NEW', 'category' => 'Cover PCB', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MCK68586003', 'part_name' => 'COVER PCB COMANG', 'category' => 'Cover PCB', 'style_bom' => 'VIPER'],
            ['customer' => 'PT. HAENG SUNG RAYA INDONESIA', 'part_number' => 'MCK68586001', 'part_name' => 'COVER PCB FREEZER', 'category' => 'Cover PCB', 'style_bom' => 'FREEZER, VIPER,'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'ACQ30726901', 'part_name' => 'COVER ASSEMBLY', 'category' => 'Cover PCB', 'style_bom' => 'VT18'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'ACQ89576401', 'part_name' => 'Cover Assembly,Machinery(Rear)', 'category' => 'Cover PCB', 'style_bom' => 'ALPHA 8'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'ACQ30726901 OSP', 'part_name' => 'OSP COVER VALVE ASSEMBLY', 'category' => 'Cover PCB', 'style_bom' => 'VT18'],
            ['customer' => 'PT. SHIN SEONG DELTA TECH INDONESIA', 'part_number' => 'MCK71866501', 'part_name' => 'COVER, VALVE', 'category' => 'Cover PCB', 'style_bom' => 'VT18'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH73776308', 'part_name' => 'HINGE ASSEMBLY LOWER VT', 'category' => 'Hinge Assy', 'style_bom' => 'LOW VT'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH76183701', 'part_name' => 'HINGE ASSEMBLY,CENTER', 'category' => 'Hinge Assy', 'style_bom' => 'HG C VT6'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH76183702', 'part_name' => 'HINGE ASSEMBLY,CENTER', 'category' => 'Hinge Assy', 'style_bom' => 'HG C VT6 H'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGF30181245', 'part_name' => 'HINGE ASSEMBLY,CENTER', 'category' => 'Hinge Assy', 'style_bom' => 'SKD HG C VT6'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGF30181251', 'part_name' => 'HINGE ASSEMBLY,CENTER', 'category' => 'Hinge Assy', 'style_bom' => 'SKD HG C VT6 (A)'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGF30181249', 'part_name' => 'HINGE ASSEMBLY,LOWER', 'category' => 'Hinge Assy', 'style_bom' => 'SKD LOWER VT'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH74216705', 'part_name' => 'HINGE ASSEMBLY,UPPER', 'category' => 'Hinge Assy', 'style_bom' => 'OMEGA'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH74296203', 'part_name' => 'Hinge Assembly,Upper', 'category' => 'Hinge Assy', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AEH74296204', 'part_name' => 'HINGE ASSEMBLY,UPPER', 'category' => 'Hinge Assy', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4218CAN0353L', 'part_name' => 'MIDDLE HINGE PATCH', 'category' => 'Hinge Assy', 'style_bom' => 'REFRIGERATOR 2 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4116CAM1151L', 'part_name' => 'UPPER HINGE PATCH', 'category' => 'Hinge Assy', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MFA63403001', 'part_name' => 'LEG FRAME OMEGA', 'category' => 'Leg Frame', 'style_bom' => 'OMEGA'],
            ['customer' => 'PT. MOVING TECH', 'part_number' => 'MFA62123401', 'part_name' => 'LEG FRAME VT 6', 'category' => 'Leg Frame', 'style_bom' => 'VT'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0376L', 'part_name' => 'M FAN BASE', 'category' => 'M FAN BASE', 'style_bom' => 'SHOW CASE - SKD'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0269L', 'part_name' => 'M MOTOR SUPPORT PATCH R', 'category' => 'M MOTOR SUPPORT PATCH R', 'style_bom' => 'EF/FREEZER CBU'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710119', 'part_name' => 'REINFORCE ASM LEFT', 'category' => 'Reinforce', 'style_bom' => 'VT12'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710120', 'part_name' => 'REINFORCE ASM RIGHT', 'category' => 'Reinforce', 'style_bom' => 'VT12'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73269901', 'part_name' => 'Reinforce Assembly', 'category' => 'Reinforce', 'style_bom' => 'OMEGA 6 R'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73269902', 'part_name' => 'Reinforce Assembly', 'category' => 'Reinforce', 'style_bom' => 'OMEGA 6 L'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73269903', 'part_name' => 'Reinforce Assembly', 'category' => 'Reinforce', 'style_bom' => 'OMEGA 8.9 R'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73269912', 'part_name' => 'REINFORCE ASSEMBLY', 'category' => 'Reinforce', 'style_bom' => '8.9 DIET L'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710101', 'part_name' => 'REINFORCE ASSEMBLY', 'category' => 'Reinforce', 'style_bom' => 'VT6 [R]'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710102', 'part_name' => 'REINFORCE ASSEMBLY', 'category' => 'Reinforce', 'style_bom' => 'VT6 [L]'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710107', 'part_name' => 'REINFORCE ASSEMBLY', 'category' => 'Reinforce', 'style_bom' => '8,9 VT6 [L]'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710108', 'part_name' => 'REINFORCE ASSEMBLY', 'category' => 'Reinforce', 'style_bom' => '8,9 VT6 [R]'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710110', 'part_name' => 'REINFORCE ASSEMBLY LEFT', 'category' => 'Reinforce', 'style_bom' => 'VT4 [L]'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AHF73710109', 'part_name' => 'REINFORCE ASSEMBLY RIGHT', 'category' => 'Reinforce', 'style_bom' => 'VT4 [R]'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4114EAQ1141L', 'part_name' => 'REINFORCE LEFT ECO', 'category' => 'Reinforce', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4114EAQ1143L', 'part_name' => 'REINFORCE RIGHT ECO', 'category' => 'Reinforce', 'style_bom' => 'REFRIGERATOR 1 DOOR'],
            ['customer' => 'PT. HASURA MITRA GEMILANG', 'part_number' => 'MJB62889901', 'part_name' => 'Stopper Door Inspiration', 'category' => 'Stopper Door', 'style_bom' => 'INSPIRASI'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJB65181101', 'part_name' => 'STOPPER DOOR', 'category' => 'Stopper Door', 'style_bom' => 'VB 4'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => '4810JM3004B-G', 'part_name' => 'STOPPER DOOR ALPHA 4 - 8N GLASS', 'category' => 'Stopper Door', 'style_bom' => '8N GLASS'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJB64309701', 'part_name' => 'Stopper Door Alpha 8', 'category' => 'Stopper Door', 'style_bom' => 'ALPHA 8'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => '4810JM3004B-B', 'part_name' => 'STOPPER DOOR ALPHA 8 BAR', 'category' => 'Stopper Door', 'style_bom' => '8 BAR'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJB62889901-B', 'part_name' => 'STOPPER DOOR ALPHA 8 BAR', 'category' => 'Stopper Door', 'style_bom' => '8 BAR'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJB62889901-P', 'part_name' => 'STOPPER DOOR ALPHA POCKET 8', 'category' => 'Stopper Door', 'style_bom' => 'INSPIRASI'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MJB62831101', 'part_name' => 'STOPPER DOOR', 'category' => 'Stopper Door', 'style_bom' => 'PRESS SCP1 T2.3 SCP1 NATURAL T2.3 KLAUS 1,2'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MJB63249701', 'part_name' => 'Stopper Door Glory', 'category' => 'Stopper Door', 'style_bom' => 'GLORY'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGF04073201', 'part_name' => 'STOPPER DOOR, PACKAGE ASSEMBLY,C/SKD - SKD INSP', 'category' => 'Stopper Door', 'style_bom' => 'SKD INSP'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AGF79658188', 'part_name' => 'STOPPER DOOR,CKD ASM FO', 'category' => 'Stopper Door', 'style_bom' => 'SKD SD'],
            ['customer' => 'PRODUKSI', 'part_number' => '4980JA3016F', 'part_name' => 'SUPPORTER,HANDLE', 'category' => 'Supporter Handle', 'style_bom' => '8N GLASS'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => '4980JA3016F-G', 'part_name' => 'SUPPORTER HANDLE ALPHA 4 - 8N GLASS', 'category' => 'Supporter Handle', 'style_bom' => '8N GLASS'],
            ['customer' => 'PT. JUAHN INDONESIA', 'part_number' => 'MJH62437102', 'part_name' => 'SUPPORTER HANDLE R (KLAUSE)', 'category' => 'Supporter Handle', 'style_bom' => 'KLAUSE'],
            ['customer' => 'PT. MOVING TECH', 'part_number' => '4980JA3016M', 'part_name' => 'Supporter Handel Long', 'category' => 'Supporter Handle', 'style_bom' => 'KLAUS'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'AJJ73022104', 'part_name' => 'Supporter Assembly,Hinge', 'category' => 'Supporter Hinge', 'style_bom' => 'OMEGA'],
            ['customer' => 'PT. LG ELECTRONICS INDONESIA', 'part_number' => 'MJH54544903', 'part_name' => 'Supporter,PCB', 'category' => 'Supporter PCB', 'style_bom' => 'PCB'],
            ['customer' => 'PT. OS TEC INDONESIA', 'part_number' => 'MJH66268304', 'part_name' => 'SUPPORTER PCB VT', 'category' => 'Supporter PCB', 'style_bom' => 'VT'],
            ['customer' => 'PT. HISYS ENGINEERING INDONESIA', 'part_number' => 'MJS65339804', 'part_name' => 'TRAY DRAIN', 'category' => 'TRAY DRAIN', 'style_bom' => '-'],
            ['customer' => 'PT. SANKEN ARGADWIJA', 'part_number' => '4S21AAN0384L', 'part_name' => 'WIRE CONDENSER SUPPORT S', 'category' => 'WIRE CONDENSER SUPPORT S', 'style_bom' => 'HOW CASE - SKD'],
        ];

        $payload = array_map(function ($row) use ($now) {
            $code = Str::upper(Str::slug($row['customer'], '-'));
            $vendor = Vendor::firstOrCreate(
                ['code' => $code],
                ['name' => $row['customer']]
            );

            return [
                'customer' => $row['customer'],
                'part_number' => $row['part_number'],
                'part_name' => $row['part_name'],
                'category' => $row['category'],
                'style_bom' => $row['style_bom'],
                'name' => $row['part_name'],
                'sku' => $row['part_number'],
                'uom' => '-',
                'description' => $row['category'],
                'vendor_id' => $vendor->id,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $rows);

        DB::table('parts')->upsert($payload, ['part_number'], [
            'customer', 'part_name', 'category', 'style_bom', 'name', 'sku', 'uom', 'description', 'vendor_id', 'updated_at',
        ]);
    }
}
