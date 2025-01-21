<?

// require_once '../models/SeasonalOfferBannerModel.php';

class SeasonalOfferBannerController extends Controller{
    // private $seasonalOfferBannerModel;

    public function __construct()
    {
    }

    public function index()
    {
        $this->model('SeasonalOfferBannerModel');
        // $seasonalOfferBannerModel = new SeasonalOfferBannerModel();

        // $data1 = $seasonalOfferBannerModel->getSeasonalOffer();


        
    }
}