<?php

namespace App\Http\Controllers;

use App\Models\People;
use Illuminate\Http\Request;

class PeopleController extends Controller
{


    public function index(Request $request)
    {
        $search = strtolower($request->query('search', ''));

        $peopleQuery = People::query();

        if (!empty($search)) {
            $peopleQuery->where(function ($query) use ($search) {
                $query->whereRaw('LOWER(name) like ?', ["%$search%"])
                    ->orWhereRaw('LOWER(age) like ?', ["%$search%"])
                    ->orWhereRaw('LOWER(gender) like ?', ["%$search%"]);
            });
        }

        $people = $peopleQuery->get();

        if ($request->ajax()) {
            $rowView = view('components.row', ['people' => $people])->render();
            return response()->json([
                'rowView' => $rowView]);
        } else {
            return view('list', ['people' => $people]);
        }

    }


    public function delete($id)
    {
        $person = People::find($id);
        if ($person) {
            $person->delete();
            return response()->json(['message' => 'Success'], 200);
        } else {
            return response()->json(['message' => 'Person not found'], 404);
        }
    }

    public function edit($id)
    {
        $person = People::find($id);
        if ($person) {
            return response()->json(['person' => $person]);
        } else {
            return response()->json(['error' => 'Person not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $person = People::find($id);
        if ($person) {
            $person->name = $request->name;
            $person->age = $request->age;
            $person->gender = $request->gender;
            $person->save();
            return response()->json(['message' => 'Person updated successfully']);
        } else {
            return response()->json(['error' => 'Person not found'], 404);
        }
    }



}
