<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('offer_status');   //Teklifin durumu. offer_status tablosundan gelir.
            $table->integer('bid_result')->nullable(); //Teklif sonucu. İlk değeri null olacak.
            $table->integer('offer_type')->default(1); // Teklif türü. Standart teklif mi, revizyon teklif mi? (1/2) Default 1.
            $table->integer('company_id'); // Teklif verilen firmanın id’si.
            $table->integer('user_id')->nullable(); // Firmada ki yetkili kişinin id’si
            $table->integer('offer_no'); // Teklif numarası.
            $table->string('title'); // Teklifin adı.
            $table->date('offer_date')->nullable(); // Teklif tarihi.
            $table->date('validity_date')->nullable(); // Son geçerlilik tarihi.
            $table->integer('curency')->nullable(); // Teklifin para biriminin id’si.c
            $table->integer('currency_rate')->nullable(); // Para biriminin nereden çekileceğinin id’si, merkez bankası, özel.
            $table->integer('custom_rate')->nullable(); // Özel kur seçildiyse değeri. Default değeri null.
            $table->text('terms_of_payment')->nullable(); // Ödeme koşulları içeriği.
            $table->text('delivery_time')->nullable(); // Teslimat süresi içeriği.
            $table->integer('cover_letter')->nullable(); // Ön yazı id’si.
            $table->integer('condition')->nullable(); // teklif şartı id’si.
            $table->integer('offer_terms')->nullable(); // Teklif şartları id’si.
            $table->text('note')->nullable(); // Not içeriği.
            $table->integer('product_attrs')->default(0); // Ürün niteliklerini göster/gizle. 1 göster, 0 gizle. Default 0.
            $table->integer('total_tax')->default(0); // Toplama KDV ekle. 1 ekle, 0 ekleme. Default 0.
            $table->integer('tax_value')->nullable(); // KDV değeri.
            $table->integer('total_discount')->nullable(); // Teklife yapılan iskonta değeri
            $table->string('offer_price')->nullable(); // Teklif para birimi tl dışında ise buraya ilgili para birimi cinsinden değeri gelecek.
            $table->integer('offer_subtotal')->nullable(); // Teklifin vergi ve iskonto öncesi toplam değeri.
            $table->integer('offer_total')->nullable(); // Teklifin TL cinsinden toplam değeri..
            $table->integer('offer_template')->nullable(); // Teklif şablon id’si.
            $table->string('bidder')->nullable(); // Teklifi sunan kişinin adı, soyadı,
            $table->string('bidder_title')->nullable(); // Teklifi sunan kişinin görevi,
            $table->string('bidder_phone')->nullable(); // Teklifi sunan kişinin telefon numarası,
            $table->string('bidder_email')->nullable(); // Teklifi sunan kişinin e-posta adresi.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
};

