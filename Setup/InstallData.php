<?php
namespace Artera\Privacy\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\CheckoutAgreements\Model\AgreementsProvider;
use Magento\CheckoutAgreements\Model\AgreementModeOptions;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Artera\Privacy\Model\Agreement as PrivacyAgreement;
use Artera\Privacy\Model\Page as PrivacyPage;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\Information as StoreInformation;

class InstallData implements InstallDataInterface
{
    protected $agreementFactory;
    protected $pageFactory;
    protected $pageRepository;
    protected $configResource;
    protected $scopeConfig;

    public function __construct(
        \Magento\CheckoutAgreements\Model\AgreementFactory $agreementFactory,
        \Magento\Cms\Model\PageFactory $pageFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Config\Model\ResourceModel\Config $configResource,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->agreementFactory = $agreementFactory;
        $this->pageFactory = $pageFactory;
        $this->pageRepository = $pageRepository;
        $this->configResource  = $configResource;
        $this->scopeConfig = $scopeConfig;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $this->configResource->saveConfig(
            AgreementsProvider::PATH_ENABLED,
            1,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );

        $owner = $this->scopeConfig->getValue(
            StoreInformation::XML_PATH_STORE_INFO_NAME,
            ScopeInterface::SCOPE_STORE
        );
        if (empty($owner)) {
            $owner = 'Nome negozio';
        }
        $content = <<<EOD
Informativa Ai sensi del D.Lgs. 196/2003 che prevede la tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali

Desideriamo informarla che i dati personali da lei forniti ovvero altrimenti acquisiti nell'ambito della nostra attività potranno essere trattati da {$owner} su supporto cartaceo e/o con l'ausilio di strumenti informatici nel rispetto della normativa di cui sopra per finalità gestionali, invio documentazione tecnica, statistiche, commerciali, marketing, promozionali o comunicazioni commerciali.
Ai sensi dell'art. 7 del D.Lgs. 196/2003 in ogni momento potrà avere accesso agli stessi dati, chiederne la modifica, la cancellazione oppure opporsi al loro utilizzo. Titolare del trattamento è {$owner}.


Oggetto dell'informativa:
Le informazioni oggetto della presente comunicazione riguardano i vostri dati personali comuni forniti da voi stessi e tutti i dati, anche sensibili (ovvero idonei a rivelare le convinzioni religiose, le opinioni politiche, l' adesione a partiti, sindacati, associazioni od organizzazioni a carattere religioso, politico e sindacale, nonché i dati idonei a rivelare lo stato di salute) da voi conferitici direttamente, nonché acquisiti in futuro sia da noi direttamente che tramite terzi oppure attraverso l'ausilio di sistemi elettronici, telematici e con ogni altro mezzo messo a disposizione dalla tecnica e dall'evoluzione tecnologica nel rispetto della legge.
Finalità del trattamento:
Il trattamento dei vostri dati avviene per finalità atte al conseguimento dei nostri scopi sociali e, comunque, connessi e strumentali alle attività della nostra società, quali ad esempio:
finalità connesse all'acquisizione di informazioni, utili all'attivazione o alla prosecuzione di rapporti con la nostra società;
finalità connesse alla personalizzazione ed all' implementazione dei servizi forniti dalla nostra società ed all'eventuale verifica del livello di soddisfazione;
finalità connesse alla comunicazione di informazioni relative a nuove offerte di prodotti e di servizi della nostra società. In particolare per i servizi relativi alla gestione della posta e di domini web, tutte le informazioni sono potenzialmente accessibili dal nostro personale unicamente per garantirvi il ripristino dei dati di vostra proprietà. {$owner} non è assolutamente responsabile del loro contenuto, né potrà utilizzare tali informazioni per fini differenti da quello indicato.


Modalità del trattamento:
I dati personali da voi forniti saranno inseriti in una banca dati e/o conservati in archivi cartacei o su supporto magnetico e saranno da noi trattati manualmente oppure attraverso l'ausilio di sistemi elettronici, telematici e con ogni altro mezzo messo a disposizione dalla tecnica e dall'evoluzione tecnologica nel rispetto della legge.
Il trattamento dei dati avverrà in modo lecito e corretto e, comunque, in modo da garantire la sicurezza e la riservatezza dei dati stessi.
I dati di vostra proprietà ed archiviati presso {$owner} in formato digitale, saranno invece conservati separatamente e saranno accessibili unicamente su vostra richiesta e per fini di manutenzione/ripristino. Non potendo distinguere i dati a cui {$owner} può potenzialmente accedere, verranno trattati come dati di tipo sensibile, e saranno pertanto adottate le corrispondenti misure di sicurezza informatiche a vostra tutela.
Natura obbligatoria e facoltativa del conferimento e conseguenze dell'eventuale rifiuto:
Il conferimento da parte vostra dei dati per le finalità di cui ai punti 2-a e 2-b sopra menzionate è obbligatorio.
L'eventuale vostro rifiuto di fornire i dati o parte di essi può comportare l'impedimento nell'esecuzione del rapporto.
Il conferimento dei dati potrebbe rappresentare, inoltre, un onere per voi necessario al fine di poterci consentire di adempiere ad obblighi legali connessi a norme civilistiche, fiscali e contabili.
Il conferimento da parte vostra dei dati per le finalità di cui al punto 2-c sopra menzionato è facoltativo.
Soggetti ai quali possono essere comunicati i dati:
I vostri dati personali potranno da noi essere comunicati, per quanto di loro rispettiva e specifica competenza, ad Enti ed in generale ad ogni soggetto pubblico e privato, società collegate, controllate, controllanti rispetto al quale vi sia per noi obbligo di comunicazione e ciò anche al fine del più corretto adempimento di ogni eventuale rispettivo obbligo (anche di natura strumentale) comunque connesso o riferibile ai rapporti presenti e futuri che si andranno con voi ad instaurare, imposto da leggi e/o regolamenti o per il conseguimento delle finalità sopra espresse. I dati in nostro possesso non saranno in nessun caso oggetto di diffusione.


Diritti dell'interessato:
Rispetto ai dati in nostro possesso, è in vostra facoltà esercitare tutti i diritti riconosciuti dall'art. 7 del D.Lgs. 196/2003, che per Sua comodità riproduciamo integralmente:
L'interessato ha diritto di ottenere la conferma dell'esistenza o meno di dati personali che lo riguardano, anche se non ancora registrati, e la loro comunicazione in forma intelligibile.
L'interessato ha diritto di ottenere l'indicazione:
dell'origine dei dati personali;
delle finalità e modalità del trattamento;
della logica applicata in caso di trattamento effettuato con l'ausilio di strumenti elettronici;
degli estremi identificativi del titolare, dei responsabili e del rappresentante designato ai sensi dell'articolo 5, comma 2;
dei soggetti o delle categorie di soggetti ai quali i dati personali possono essere comunicati o che possono venirne a conoscenza in qualità di rappresentante designato nel territorio dello Stato, di responsabili o incaricati.
L'interessato ha diritto di ottenere:
l'aggiornamento, la rettificazione ovvero, quando vi ha interesse, l'integrazione dei dati;
la cancellazione, la trasformazione in forma anonima o il blocco dei dati trattati in violazione di legge, compresi quelli di cui non è necessaria la conservazione in relazione agli scopi per i quali i dati sono stati raccolti o successivamente trattati;
l'attestazione che le operazioni di cui alle lettere a) e b) sono state portate a conoscenza, anche per quanto riguarda il loro contenuto, di coloro ai quali i dati sono stati comunicati o diffusi, eccettuato il caso in cui tale adempimento si rivela impossibile o comporta un impiego di mezzi manifestamente sproporzionato rispetto al diritto tutelato.
L'interessato ha diritto di opporsi, in tutto o in parte:
per motivi legittimi al trattamento dei dati personali che lo riguardano, ancorché pertinenti allo scopo della raccolta;
al trattamento di dati personali che lo riguardano a fini di invio di materiale pubblicitario o di vendita diretta o per il compimento di ricerche di mercato o di comunicazione commerciale.
EOD;
        $agreementData = [
            'name' => 'Privacy Policy',
            'is_active' => 1,
            'is_html' => 0,
            'mode' => AgreementModeOptions::MODE_MANUAL,
            'stores' => [0],
            'checkbox_text' => 'Autorizzo il trattamento dei dati personali ai sensi dell\'articolo 13 d.lgs. 196/2003',
            'content' => $content,
            'content_height' => ''
        ];
        $agreement = $this->createAgreement()->setData($agreementData)->save();
        $this->configResource->saveConfig(
            PrivacyAgreement::XML_PATH_PRIVACY_SETTINGS_AGREEMENT_ID,
            $agreement->getId(),
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );

        try {
            $this->pageRepository->getById(PrivacyPage::PAGE_IDENTIFIER);
        } catch (NoSuchEntityException $e) {
            $pageData = [
                'title' => 'Privacy Policy',
                'content_heading'   => 'Privacy Policy',
                'page_layout' => '1column',
                'identifier' => PrivacyPage::PAGE_IDENTIFIER,
                'content' => '{{widget type="Artera\Privacy\Block\Widget"}}',
                'is_active' => 1,
                'stores' => [0],
                'sort_order' => 0,
            ];
            $this->createPage()->setData($pageData)->save();
        }
    }

    public function createAgreement()
    {
         return $this->agreementFactory->create();
    }

    public function createPage()
    {
        return $this->pageFactory->create();
    }
}
