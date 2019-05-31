from django.conf import settings
from django.db import models
from django.utils import timezone


class Post(models.Model):
    author = models.ForeignKey(settings.AUTH_USER_MODEL, on_delete=models.CASCADE)
    title = models.CharField(max_length=200)
    text = models.TextField()
    created_date = models.DateTimeField(default=timezone.now)
    published_date = models.DateTimeField(blank=True, null=True)
    picture = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/template.jpg')

    def publish(self):
        self.published_date = timezone.now()
        self.save()

    def __str__(self):
        return self.title


class Header(models.Model):
    daily_schedule = models.TextField()
    mail = models.TextField()
    phone = models.TextField()
    delivery = models.TextField()
    link_to_insta = models.TextField()
    link_to_facebook = models.TextField()
    link_to_vk = models.TextField()
    rent_rules = models.TextField()
    main_letter = models.TextField()
    logo34x46 = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/logo.jpg')


class Slider(models.Model):
    picture1 = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/template.jpg')
    picture2 = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/bgHome3.jpg')
    picture3 = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/bgHome2.jpg')
    headline1 = models.TextField()
    headline2 = models.TextField()
    headline3 = models.TextField()
    link1 = models.TextField()
    link2 = models.TextField()
    link3 = models.TextField()


class Thebigthree(models.Model):
    title = models.TextField()
    color = models.TextField()
    picture = models.ImageField(upload_to = 'Fisher/app/img/banners', default = 'Fisher/app/img/banners/banner3.png')


class Leaders(models.Model):
    button_name =  models.TextField()
    leaders_of_sale = models.TextField()
    picture_12x16 = models.ImageField(upload_to = 'Fisher/app/img/icons', default = 'Fisher/app/img/icons/logo.png')
    button_left_text = models.TextField()
    button_right_text = models.TextField()  


class LeadersStaff(models.Model):
    add_text_in_frame = models.TextField()
    color_of_frame = models.TextField()
    picture_600x434 = models.ImageField(upload_to = 'Fisher/app/img/items', default = 'Fisher/app/img/items/udilische_600x434.jpg')
    name = models.TextField()
    stars = models.TextField()
    new_price = models.TextField()
    old_price = models.TextField()


class SecondSlider(models.Model):
    title = models.TextField()
    stars = models.TextField()
    new_price = models.TextField()
    old_price = models.TextField()
    description = models.TextField()
    picture_600x600 = models.ImageField(upload_to = 'Fisher/app/img/items', default = 'Fisher/app/img/items/udilische_600x434.jpg')


class Hire(models.Model):
    title = models.TextField()
    picture_12x16 = models.ImageField(upload_to = 'Fisher/app/img/icons', default = 'Fisher/app/img/icons/logo.png')
    button_text = models.TextField()


class HireStaff(models.Model):
    add_text_in_frame = models.TextField()
    color_of_frame = models.TextField()
    picture_600x434 = models.ImageField(upload_to = 'Fisher/app/img/items', default = 'Fisher/app/img/items/udilische_600x434.jpg')
    name = models.TextField()
    stars = models.TextField()
    new_price = models.TextField()
    old_price = models.TextField()


class TheLastThree(models.Model):
    title = models.TextField()
    text = models.TextField()
    picture = models.ImageField(upload_to = 'Fisher/app/img/icons', default = 'Fisher/app/img/icons/freeShipping.png')
   

class Footer(models.Model):
    logo34x46 = models.ImageField(upload_to = 'Fisher/app/img', default = 'Fisher/app/img/logo.jpg')
    link_to_insta = models.TextField()
    link_to_facebook = models.TextField()
    link_to_vk = models.TextField()
    main_letter = models.TextField()
    description = models.TextField()
    copyrightt = models.TextField()


class Rent(models.Model):
    category = models.TextField()
    add_text_in_frame = models.TextField()
    color_of_frame = models.TextField()
    stars = models.TextField()
    rent_price = models.TextField()
    picture_600x600 = models.ImageField(upload_to = 'Fisher/app/img/items', default = 'Fisher/app/img/items/118ee07b6b6471b0a5e587d09985e6ad.jpg')


class Contacts(models.Model):
    location = models.TextField()
    number = models.TextField()
    email = models.TextField()
    address = models.TextField()
    