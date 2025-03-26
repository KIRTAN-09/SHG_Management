namespace App\Exports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;

class GroupsExport implements FromCollection
{
    public function collection()
    {
        return Group::all();
    }
}
