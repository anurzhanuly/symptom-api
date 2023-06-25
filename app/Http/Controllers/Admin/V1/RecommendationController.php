<?php
namespace App\Http\Controllers\Admin\V1;

use App\Http\Controllers\Controller;
use App\Symptom\Services\Recommendations\CreateRecommendation;
use App\Symptom\Services\Recommendations\DeleteRecommendation;
use App\Symptom\Services\Recommendations\GetAllRecommendations;
use App\Symptom\Services\Recommendations\UpdateRecommendation;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    public function index(
        Request $request,
        GetAllRecommendations $getAllRecommendationsService,
    ): View {
        $message         = $request->session()->get('message');
        $recommendations = $getAllRecommendationsService->execute();

        return \view('admin.recommendation.index', compact('message', 'recommendations'));
    }

    public function create(Request $request)
    {
        $message = $request->session()->get('message');

        return \view('admin.recommendation.create', compact('message'));
    }

    public function handleCreate(
        Request $request,
        CreateRecommendation $createRecommendationService
    ) {
        $recommendation = $createRecommendationService->execute([
            'name'       => $request->get('name'),
            'tests'      => json_decode($request->get('tests'), true),
            'conditions' => json_decode($request->get('conditions'), true),
        ]);

        return redirect()->back()->with('message', 'Рекомендация '. $recommendation->getName() . ' добавленa');
    }

    public function update(
        Request $request,
        UpdateRecommendation $updateRecommendationService,
    ) {
        $recommendation = $updateRecommendationService->execute(
            (int) $request->get('id'),
            [
                'name'       => $request->get('name'),
                'tests'      => $request->get('tests'),
                'conditions' => $request->get('conditions'),
            ]);

        return redirect()->back()->with('message', 'Рекомендация '. $recommendation->getName() . ' обновленa');
    }

    public function delete(Request $request, DeleteRecommendation $deleteRecommendationService)
    {
        if ($deleteRecommendationService->execute((int) $request->get('id'))) {
            return redirect()->back()->with('message', 'Рекомендация удалена');
        }

        return redirect()->back()->with('message', 'Рекомендация не была удалена');
    }
}
