from django.shortcuts import render, get_object_or_404
from django.utils import timezone
from .models import Post
from .models import Header
from .models import Slider
from .models import Thebigthree
from .models import Leaders
from .models import LeadersStaff
from .models import SecondSlider
from .models import Hire
from .models import HireStaff
from .models import TheLastThree
from .models import Footer
from .models import Rent
from .models import Contacts
from django.shortcuts import redirect
from .forms import PostForm


def post_list(request):
    posts = Post.objects.filter(published_date__lte=timezone.now()).order_by('published_date')
    return render(request, 'blog/Fisher/app/blog.php', {'posts': posts})

def header_list(request):
    posts = Header.objects.filter()
    return render(request, 'blog/Fisher/app/header.php', {'posts': posts})

def slider_list(request):
    posts = Slider.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def thebigthree_list(request):
    posts = Thebigthree.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def leaders_list(request):
    posts = Leaders.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def leadersstaff_list(request):
    posts = LeadersStaff.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def secondslider_list(request):
    posts = SecondSlider.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def hire_list(request):
    posts = Hire.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def hirestaff_list(request):
    posts = HireStaff.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def thelastthree_list(request):
    posts = TheLastThree.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def footer_list(request):
    posts = Footer.objects.filter()
    return render(request, 'blog/Fisher/app/footer.php', {'posts': posts})

def rent_list(request):
    posts = Rent.objects.filter()
    return render(request, 'blog/Fisher/app/index.php', {'posts': posts})

def contacts_list(request):
    posts = Contacts.objects.filter()
    return render(request, 'blog/Fisher/app/contacts.php', {'posts': posts})