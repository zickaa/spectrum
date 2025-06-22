<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tds;
use App\Models\Ultrasonic;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Repositories\MemoryRepository;
use Psr\Log\NullLogger;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Subscribe MQTT dan simpan data sensor ke database';

    public function handle()
    {
        $server   = '192.168.32.252';
        $port     = 1883;
        $clientId = 'laravel_mqtt_client';

        // Inisialisasi MQTT client, parameter sesuai urutan:
        // host, port, clientId, protocolVersion, repository, logger
        $client = new MqttClient(
            $server,
            $port,
            $clientId,
            MqttClient::MQTT_3_1,
            new MemoryRepository(),
            new NullLogger()
        );

        // Connect ke broker MQTT
        $client->connect();

        // Subscribe topik TDS
        $client->subscribe('iot/tds', function (string $topic, string $message) {
            $this->info("TDS data diterima: $message");

            $data = json_decode($message, true);
            if ($data) {
                Tds::create([
                    'device_id'       => $data['device_id'] ?? 0,
                    'nutrisi_ppm'     => $data['nutrisi_ppm'] ?? 0,
                    'pompa_nutrisi'   => filter_var($data['pompa_nutrisi'], FILTER_VALIDATE_BOOLEAN),
                    'pompa_aliran'    => filter_var($data['pompa_aliran'], FILTER_VALIDATE_BOOLEAN),
                    'dinamo_pengaduk' => filter_var($data['dinamo_pengaduk'] ?? false, FILTER_VALIDATE_BOOLEAN), // <- INI WAJIB
                    'status_nutrisi'  => $data['status_nutrisi'] ?? '',
                    'status_ideal'    => $data['status_ideal'] ?? '',
                ]);
                $this->info('TDS data saved');
            }
        }, 0);

        // Subscribe topik Ultrasonic
        $client->subscribe('iot/ultrasonic', function (string $topic, string $message) {
            $this->info("Ultrasonic data diterima: $message");

            $data = json_decode($message, true);
            if ($data) {
                Ultrasonic::create([
                    'device_id'    => $data['device_id'] ?? 0,
                    'jarak_air'    => $data['jarak_air'] ?? 0,
                    'pompa_air'    => filter_var($data['pompa_air'], FILTER_VALIDATE_BOOLEAN),
                    'status_air'   => $data['status_air'] ?? '',
                ]);
                $this->info('Ultrasonic data saved');
            }
        }, 0);

        // Jalankan loop agar terus listen message masuk
        $client->loop(true);
    }
}
