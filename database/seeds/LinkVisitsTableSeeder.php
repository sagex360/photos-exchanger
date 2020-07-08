<?php


use App\Models\FileLinkToken;
use App\Models\LinkVisit;
use App\ValueObjects\LinkToken\LinkTokensFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;

final class LinkVisitsTableSeeder extends Seeder
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public static function limit(): int
    {
        return 150;
    }

    protected function findLinkToken(bool $useRandomTypes = true): FileLinkToken
    {
        $type = (!$useRandomTypes) ?
            'unlimited'
            : $this->faker->randomElement(LinkTokensFactory::supportedTypes());

        $builder = FileLinkToken::whereType($type)
            ->inRandomOrder();

        if ($type === 'disposable') {
            try {
                $token = $builder
                    ->doesntHave('visits')
                    ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $token = $this->findLinkToken(false);
            }
        } else {
            $token = $builder->first();
        }

        return $token;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 0; $i < self::limit(); ++$i) {
            $linkVisit = new LinkVisit();

            $fileLinkToken = $this->findLinkToken();
            $linkVisit->link_token_id = $fileLinkToken->id;

            $linkVisit->save();
        }
    }
}
