use Illuminate\Support\Facades\DB;

public function run(): void
{
DB::table('level')->insert([
[
'id_level' => 1,
'nama_level' => 'siswa'
],
[
'id_level' => 2,
'nama_level' => 'pembina'
],
[
'id_level' => 3,
'nama_level' => 'admin'
]
]);
}